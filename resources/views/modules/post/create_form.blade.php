<div class="p-4">
    <div class="form-group row">
        <label class="col-12 mb-2 control-label text-bold-700">{{ __("Post Title") }}<span class="text-danger text-bold-700">*</span></label>

        <div class="col-12 col-md-8 mb-2">
            <input type="text" class="form-control" name="title" id="title" value={{ $model->title }}>
            <small class="from-text text-danger" id="title_error"></small>
        </div>
    </div>
    <hr>
    <textarea name="body" id="" cols="30" rows="30" class="summer">{!! $model->body !!}</textarea>
</div>


<script type="module">
    Swal.fire("Hello")
    $("#title").inputmask('numeric', {
        radixPoint: '',
        showMaskOnHover: false,
        showMaskOnFocus: false,
        clearMaskOnLostFocus: true,
        groupSeparator: '',
        autoGroup: true,
        prefix: '',
        maxLength: 16,
        placeholder: '',
        rightAlign: false,
        onBeforeMask: function(value, opts) {
            return value.replace(/[^\d]/g, '');
 }
 });
</script>
