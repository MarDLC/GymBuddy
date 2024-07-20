
    // Ottieni i parametri dall'URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    const nome = urlParams.get('nome');
    const cognome = urlParams.get('cognome');

    // Contatore per i campi di esercizio aggiunti dinamicamente
    let exerciseCounter = 1;

    // Gestione del click sul pulsante "Aggiungi"
    document.getElementById('addExerciseButton').addEventListener('click', function () {
    exerciseCounter++;

    // Crea un nuovo set di campi di esercizio
    const newExerciseSet = document.createElement('div');
    newExerciseSet.classList.add('exercise-set');

    newExerciseSet.innerHTML = `
        <div class="form-group">
            <label for="exercise${exerciseCounter}">Exercise</label>
            <input type="text" class="form-control" id="exercise${exerciseCounter}" name="exercise[]" placeholder="Exercise">
        </div>
        <div class="form-group">
            <label for="repetitions${exerciseCounter}">Repetitions</label>
            <input type="text" class="form-control" id="repetitions${exerciseCounter}" name="repetitions[]" placeholder="Repetitions">
        </div>
        <div class="form-group">
            <label for="recovery${exerciseCounter}">Recovery</label>
            <input type="text" class="form-control" id="recovery${exerciseCounter}" name="recovery[]" placeholder="Recovery (minutes ' seconds'')">
        </div>
    `;

    // Aggiungi il nuovo set di campi al contenitore
    document.getElementById('exerciseContainer').appendChild(newExerciseSet);
});

