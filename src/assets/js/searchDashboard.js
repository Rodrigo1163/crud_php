const search = document.getElementById('pesquisar')
function searchRedirect() {
    if (search.value === '') {
        window.location = `dashboard.php`;
        return
    }
    window.location = `dashboard.php?search=${search.value}`;
}