function editUser(id, name, email, age) {
    document.getElementById('user_id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('age').value = age;

    document.getElementById('add_button').style.display = 'none';
    document.getElementById('update_button').style.display = 'inline';
}
