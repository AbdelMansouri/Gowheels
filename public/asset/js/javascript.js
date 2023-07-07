// MAJ Jours et prix sur fiche
document.addEventListener("DOMContentLoaded", function () {
  const datepickers = Array.from(document.querySelectorAll(".datepicker"));
  const datesDiv = document.getElementById("nombre-jours");
  const prixDiv = document.getElementById("prix-total");

  const calculJourPrix = () => {
    const [datepicker1, datepicker2] = datepickers.map(
      (datepicker) => new Date(datepicker.value)
    );

    if (!isNaN(datepicker1) && !isNaN(datepicker2)) {
      let differenceDeTemps = datepicker2.getTime() - datepicker1.getTime();
      let differenceEnJours = differenceDeTemps / (1000 * 3600 * 24);
      differenceEnJours = Math.floor(differenceEnJours) + 1;

      if (differenceEnJours < 0) {
        differenceEnJours = 0;
      }

      datesDiv.textContent = differenceEnJours + " j";

      const prixJournalier =
        document.getElementById("prix-journalier").dataset.prixJournalier;
      let totalPrix = prixJournalier * differenceEnJours;
      if (totalPrix < 0) {
        totalPrix = 0;
      }

      prixDiv.textContent = totalPrix + "€";
    }
  };

  datepickers.forEach((datepicker) => {
    datepicker.addEventListener("change", calculJourPrix);
  });
});
