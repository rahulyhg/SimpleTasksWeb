function submit(formInput, formLabel)
{
    if(formInput === null || formLabel === null)
    {
        return;
    }

    formInput.value =  formLabel.innerHTML;
    document.editOnPageForm.submit();
}