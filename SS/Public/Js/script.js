// ICON INTERATIVO
function showUserInfo() {
    const userInfo = document.getElementById('user-info');
    
    if (userInfo.style.display === 'block') {
        userInfo.style.display = 'none';
    } else {
        userInfo.style.display = 'block';
    }
}

function logout() {
    alert('Você foi desconectado.');
    window.location.href = "../Login/logout.php";
}