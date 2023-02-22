<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div class="w-full" x-data="{
                state: $wire.entangle('{{ $getStatePath() }}'),
                get formattedState() {
                    return this.state;
                }
         }"
         x-init="$nextTick(() => {
            const theme = localStorage.getItem('theme');

            if (typeof script_editor !== 'undefined') {
                script_editor = ace.edit($refs.editor);
            } else {
                var script_editor = ace.edit($refs.editor);
            }
            if (theme === 'light') {
                script_editor.setTheme('{{ $getTheme('light') }}');
            } else {
                script_editor.setTheme('{{ $getTheme('dark') }}');
            }
            script_editor.session.setMode('ace/mode/tcl');
            script_editor.setValue(formattedState, -1);
            script_editor.clearSelection(); // remove the highlight over the text
            script_editor.session.on('change', function(delta) {
                state = script_editor.getSession().getValue();
            });
            script_editor.setOptions({
                enableBasicAutocompletion: true,
                enableSnippets: true,
                enableLiveAutocompletion: false
            });
            var StatusBar = ace.require('ace/ext/statusbar').StatusBar;
            // create a simple selection status indicator
            var statusBar = new StatusBar(script_editor, document.getElementById('ace_status-bar'));

            (function enableStatusBar() {
                var statusBar = document.getElementById('ace_status-bar');
                var lang = ace.require('ace/lib/lang');
                var statusUpdate = lang.delayedCall(function(){
                    this.updateStatus(script_editor)
                }.bind(this)).schedule.bind(null, 100);
                var statusUpdate = lang.delayedCall(function(){
                    var status = [];
                    function add(str, separator) {
                        str && status.push(str, separator || ' | ');
                    }
                    //
                    add(script_editor.keyBinding.getStatusText(script_editor));
                    if (script_editor.commands.recording) add('REC');
                    //
                    var sel = script_editor.selection;
                    var c = sel.lead;
                    //
                    if (!sel.isEmpty()) {
                        var r = script_editor.getSelectionRange();
                        add('(' + (r.end.row - r.start.row) + ':'  +(r.end.column - r.start.column) + ')', ' ');
                    }
                    add('Ln: ' + (c.row + 1) + ' Col: ' + (c.column + 1), ' ');

                    if (sel.rangeCount) add('[' + sel.rangeCount + ']', ' ');
                    status.pop();
                    statusBar.textContent = status.join('');
                }.bind(this)).schedule.bind(null, 100);

                script_editor.on('changeStatus', statusUpdate);
                script_editor.on('changeSelection', statusUpdate);
                script_editor.on('keyboardActivity', statusUpdate);
                statusUpdate();
            })();

            // --- maximum script size support - begin
            var doc = script_editor.session.doc;
            doc.applyAnyDelta = doc.applyAnyDelta || doc.applyDelta
            doc.applyDelta = function(delta) {
                let joinedLines = delta.lines.join('\n')

                if (delta.action == 'insert' && this.$maxLength &&
                    this.getValue().length + joinedLines.length > this.$maxLength) {

                    let newPasteLength = this.$maxLength - this.getValue().length
                    // Get the text content of the editor
                    let text = this.getValue();
                    // Get the size of the text in bytes
                    let byteLength = new TextEncoder().encode(text).byteLength;
                    console.log('Text size: ', byteLength, 'bytes');
                    if (newPasteLength > 0) {
                        delta.lines = joinedLines.substr(0, newPasteLength).split('\n')
                        if (delta.lines.length == 1 && delta.start.row == delta.end.row) {
                            delta.end = {
                                row: delta.start.row,
                                column: delta.start.column + newPasteLength
                            }
                        } else {
                            delta.end = {
                                row: delta.start.row + delta.lines.length,
                                column: delta.lines[delta.lines.length - 1].length
                            }
                        }
                    } else {
                        alert('Maximum script size supported {{$getMaxTextSize()}} bytes.');
                        return false;
                    }
                }
                return this.applyAnyDelta(delta);
            }
            doc.$maxLength = {{$getMaxTextSize()}}
            // --- maximum script size support - end
         })"
         x-on:dark-mode-toggled.window="editorSwitchTheme($event.detail, $refs.editor);"
         x-cloak
         wire:ignore>
        <pre x-ref="editor" id="editor" class="w-full ace_editor"
            style="min-height: 60vh;height:{{$getHeight()}}px;"
             >{{ $getState() }}</pre>
        <div id="ace_status-bar">ace status line</div>
    </div>
</x-forms::field-wrapper>

@once
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.1/ace.js" integrity="sha512-CfVYqNC369iSfGgZbSujTgySaSOMo+zxwXu2s9hNKiWmPGFNpXZn69kJ9tLMfwKGtZk86ZufAN1Q9EVranSAaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.2/ext-language_tools.min.js" integrity="sha512-jwHjfXzlZZWm/JrYIjGauBO9fNDoxtrl5uVEh8SVu5nZGO38FCFiHx7N5NfLQWsi+cjT4vQcZl9UNLc3oCm+TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.2/ext-statusbar.min.js" integrity="sha512-eX2592PABdFExxA/fowxeNjxiQSbb2GHXLV7C6YebfTKp4fTuQ2RUacG9PeJIh7HWLwM3A6MkFtV+xBaAujVoQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', function() {
                console.log('script-editor DOMContentLoaded');
            });
            function editorSwitchTheme(theme, refs_editor) {
                let script_editor = ace.edit(refs_editor);
                if (typeof script_editor !== 'undefined') {
                    if (theme === 'light') {
                        script_editor.setTheme('{{ $getTheme('light') }}');
                    } else {
                        script_editor.setTheme('{{ $getTheme('dark') }}');
                    }
                }
            }
        </script>
    @endpush
    @push('styles')
        <style type="text/css" media="screen">
            #editor {
                margin: 0;
                position: absolute;
                top: 0;
                bottom: 20px;
                left: 0;
                right: 0;
            }
            #ace_status-bar {
                margin: 0;
                padding: 0;
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                height: 20px;
                background-color: rgb(245, 245, 245);
                color: gray;
            }
            .ace_status-indicator {
                color: gray;
                position: absolute;
                right: 0;
                border-left: 1px solid;
            }
        </style>
    @endpush
@endonce

