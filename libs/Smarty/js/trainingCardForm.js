// Ottieni i parametri dall'URL
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');
const nome = urlParams.get('nome');
const cognome = urlParams.get('cognome');

// Contatore per i campi di esercizio aggiunti dinamicamente
let exerciseCounter = 1;

// Funzione per controllare se tutti i campi sono compilati
function allFieldsFilled() {
    const inputs = document.querySelectorAll('#exerciseContainer input');
    for (let input of inputs) {
        if (!input.value.trim()) {
            return false;
        }
    }
    return true;
}

// Gestione del click sul pulsante "Aggiungi"
document.getElementById('addExerciseButton').addEventListener('click', function () {
    if (!allFieldsFilled()) {
        alert('Please fill in all fields before adding a new exercise.');
        return;
    }

    exerciseCounter++;

    // Crea un nuovo set di campi di esercizio
    const newExerciseSet = document.createElement('div');
    newExerciseSet.classList.add('exercise-set');

    newExerciseSet.innerHTML = `
        <div class="form-group">
            <label for="exercise${exerciseCounter}">Exercise</label>
            <input type="text" class="form-control" id="exercise${exerciseCounter}" name="exercises[]" placeholder="Exercise" required>
        </div>
        <div class="form-group">
            <label for="repetitions${exerciseCounter}">Repetitions</label>
            <input type="text" class="form-control" id="repetitions${exerciseCounter}" name="repetition[]" placeholder="Repetitions" required>
        </div>
        <div class="form-group">
            <label for="recovery${exerciseCounter}">Recovery</label>
            <input type="number" class="form-control" id="recovery${exerciseCounter}" name="recovery[]" placeholder="Recovery (minutes ' seconds'')" required>
        </div>
    `;

    // Aggiungi il nuovo set di campi al contenitore
    document.getElementById('exerciseContainer').appendChild(newExerciseSet);
});
