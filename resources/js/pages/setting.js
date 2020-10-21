const formSetting = document.getElementById('form-setting');

if (formSetting) {
    const selectManagementRegistration = formSetting.querySelector('#management-registration');
    const selectDefaultManagementGroup = formSetting.querySelector('#default-management-group');
    selectManagementRegistration.addEventListener('change', function () {
        if (this.checked) {
            selectDefaultManagementGroup.disabled = false;
        } else {
            selectDefaultManagementGroup.value = '';
            selectDefaultManagementGroup.disabled = true;
        }
    });
    selectManagementRegistration.dispatchEvent(new Event('change'));
}
