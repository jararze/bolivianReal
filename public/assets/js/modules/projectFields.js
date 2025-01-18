export const initProjectFields = () => {
    const toggleProjectFields = (value) => {
        const projectFields = document.getElementById('project-fields');
        const fields = projectFields?.querySelectorAll('input, select');

        if (!projectFields) return;

        if (value === '1') {
            projectFields.style.display = 'block';
            fields.forEach(field => field.disabled = false);
        } else {
            projectFields.style.display = 'none';
            fields.forEach(field => {
                field.disabled = true;
                if (field.type === 'text' || field.type === 'number') {
                    field.value = '';
                }
            });
        }
    };

    // Initial setup
    const isProjectSelect = document.getElementById('is_project');
    if (isProjectSelect) {
        isProjectSelect.addEventListener('change', (e) => toggleProjectFields(e.target.value));
        toggleProjectFields(isProjectSelect.value);
    }
};
