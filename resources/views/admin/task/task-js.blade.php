<script>
document.querySelectorAll('.btn-edit-task').forEach((button) => {
    button.addEventListener('click', function () {
        const d = this.dataset;
        document.getElementById('taskEditForm').action = d.action;
        document.getElementById('edit_task_title').value = d.title || '';
        document.getElementById('edit_task_event_id').value = d.event_id || '';
        document.getElementById('edit_task_assigned_to').value = d.assigned_to || '';
        document.getElementById('edit_task_priority').value = d.priority || 'medium';
        document.getElementById('edit_task_status').value = d.status || 'todo';
        document.getElementById('edit_task_due_at').value = d.due_at || '';
        document.getElementById('edit_task_completed_at').value = d.completed_at || '';
        document.getElementById('edit_task_description').value = d.description || '';
        (new bootstrap.Modal(document.getElementById('taskEditModal'))).show();
    });
});
</script>
