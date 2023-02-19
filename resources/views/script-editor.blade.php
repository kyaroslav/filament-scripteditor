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
        })"
         x-on:dark-mode-toggled.window="editorSwitchTheme($event.detail, $refs.editor);"
         x-cloak
         wire:ignore>
        <pre x-ref="editor" id="editor" class="w-full ace_editor"
            style="min-height: 60vh;height:{{$getHeight()}}px;"
             >{{ $getState() }}</pre>

    </div>
</x-forms::field-wrapper>

@once
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.1/ace.js" integrity="sha512-CfVYqNC369iSfGgZbSujTgySaSOMo+zxwXu2s9hNKiWmPGFNpXZn69kJ9tLMfwKGtZk86ZufAN1Q9EVranSAaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.2/ext-language_tools.min.js" integrity="sha512-jwHjfXzlZZWm/JrYIjGauBO9fNDoxtrl5uVEh8SVu5nZGO38FCFiHx7N5NfLQWsi+cjT4vQcZl9UNLc3oCm+TA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
@endonce

