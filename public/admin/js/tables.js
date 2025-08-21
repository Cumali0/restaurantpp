function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openEditModal(id, name, capacity, status, floor) {
    document.getElementById('editModal').style.display = 'flex';
    document.getElementById('editName').value = name;
    document.getElementById('editCapacity').value = capacity;
    document.getElementById('editStatus').value = status;
    document.getElementById('editFloor').value = floor;
    document.getElementById('editForm').action = '/admin/tables/' + id;
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
