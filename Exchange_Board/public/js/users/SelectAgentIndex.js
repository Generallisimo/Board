document.addEventListener('DOMContentLoaded', function(){
    const role = document.getElementById('role');
    const market = document.getElementById('market');
    const support = document.getElementById('unsupport')

    role.addEventListener('change', function(){
        const selectedRole = role.value;

        market.style.display = 'none';

        // Показываем секцию в зависимости от выбранной роли
        if (selectedRole === 'client') {
            market.style.display = 'none';
            support.style.display = 'block'
        } else if (selectedRole === 'market') {
            market.style.display = 'block';
            support.style.display = 'block'
        } else if (selectedRole === 'agent') {
            market.style.display = 'none';
            support.style.display = 'block'
        } else if (selectedRole === 'support'){
            support.style.display = 'none'
        }
    });

    role.dispatchEvent(new Event('change'))
})