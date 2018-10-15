$(function () {
    $('.demo-form').parsley().on('form:validate', function (formInstance) {
        var ok = formInstance.isValid({group: 'block1', force: true})

        if (!ok)
            formInstance.validationResult = false;
    });
});