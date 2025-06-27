<div x-data="{ show: false, method_name: '', modal_title: '' }" x-init="$watch('show_edit_request_field', value => {
    show = value
    method_name = 'update_request'
    modal_title = 'Kérelem szerkesztése'
    if (value) $dispatch('show_edit_request_field', [update_request_id])
});

$watch('show', value => {
    if (!value) {
        show_edit_request_field = value
    }

});">
    <x-modal :name="'Kérelem szerkesztése'">
        <livewire:user.components.worker-request-form-panel :$departments :$columns />
    </x-modal>
</div>
