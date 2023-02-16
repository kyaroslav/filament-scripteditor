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
            isJson: {{ json_encode($getJsonFormatted()) }},
            get formattedState() {
                return this.isJson ? this.state : JSON.parse(this.state)
            }
        }"
         x-init="$nextTick(() => {
        const options = {
            modes: {{ $getModes() }},
            history: true,
            onChange: function(){
            },
            onChangeJSON: function(json){
                state=JSON.stringify(json);
            },
            onChangeText: function(jsonString){
                state=jsonString;
            },
            onValidationError: function (errors) {
                errors.forEach((error) => {
                  switch (error.type) {
                    case 'validation': // schema validation error
                      break;
                    case 'error':  // json parse error
                        console.log(error.message);
                      break;
                  }
                })
            }
        };
        if(typeof json_editor !== 'undefined'){
            //json_editor = new ScriptEditor($refs.editor, options);
            //json_editor.set(formattedState);
        }else{
            //let json_editor = new ScriptEditor($refs.editor, options);
            //json_editor.set(formattedState);
        }

        var editor = ace.edit('editor');
        editor.setTheme('ace/theme/twilight');
        editor.session.setMode('ace/mode/javascript');

    })"
         x-cloak
         wire:ignore>

        <pre x-ref="editor" id="editor" class="w-full ace_editor" style="min-height: 30vh;height:{{ $getHeight() }}px">function foo(items) {
            var i;
            for (i = 0; i &lt; items.length; i++) {
                alert("Ace Rocks " + items[i]);
            }
        }</pre>

    </div>
</x-forms::field-wrapper>

