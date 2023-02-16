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
        if (typeof script_editor !== 'undefined') {
            script_editor = ace.edit($refs.editor);
            script_editor.setTheme('ace/theme/twilight');
            script_editor.session.setMode('ace/mode/javascript');
            script_editor.setValue(formattedState);
            script_editor.session.on('change', function(delta) {
                state = script_editor.getSession().getValue();
            });
        } else {
            let script_editor = ace.edit($refs.editor);
            script_editor.setTheme('ace/theme/twilight');
            script_editor.session.setMode('ace/mode/javascript');
            script_editor.setValue(formattedState);
            script_editor.session.on('change', function(delta) {
                state = script_editor.getSession().getValue();
            });
        }

        script_editor.setOptions({
            maxLines: 30,
            minLines: 30,
            autoScrollEditorIntoView: true,
        });
    })"
         x-cloak
         wire:ignore>
        <pre x-ref="editor" id="editor" class="w-full ace_editor" style="min-height: 30vh;height:{{ $getHeight() }}px"></pre>

    </div>
</x-forms::field-wrapper>

@once

{{--    {{ config('filament-simple-highlight-field.theme', 'default') }}--}}

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.15.1/ace.js" integrity="sha512-CfVYqNC369iSfGgZbSujTgySaSOMo+zxwXu2s9hNKiWmPGFNpXZn69kJ9tLMfwKGtZk86ZufAN1Q9EVranSAaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script type="text/javascript">
            window.addEventListener('DOMContentLoaded', function() {
                console.log('script-editor DOMContentLoaded');
            });
        </script>
    @endpush
@endonce

