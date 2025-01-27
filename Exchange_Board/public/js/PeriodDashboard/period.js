document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('turnoverChart').getContext('2d');


    // Инициализация графика
    var turnoverChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Месяцы, дни, недели и т.д.
            datasets: [{
                label: 'Оборот',
                data: [], // Данные оборота
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true, // Заливка под графиком
                tension: 0.4 // Сглаживание линий (0.4 для плавной волнистой линии)
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Обработчик изменения фильтра
    document.getElementById('timePeriod').addEventListener('change', function() {
        fetchTurnoverData(this.value);
    });

    // Функция получения данных
    function fetchTurnoverData(period) {
        const hash_id = document.getElementById('hash_id').value;
        console.log(hash_id); // Убедись, что hash_id отображается правильно

        fetch(`/api/turnover/${period}/${hash_id}`)
            .then(response => response.json())
            .then(data => {
                console.log(data); // Добавьте это для проверки данных

                turnoverChart.data.labels = data.labels;
                turnoverChart.data.datasets[0].data = data.values;
                turnoverChart.update();
            });
    }
    // Инициализация с текущим периодом (например, день)
    fetchTurnoverData('day', hash_id);
});
