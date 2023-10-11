//const declarations
const putLimit = document.querySelector("#limit");
const limitSpend = document.querySelector("#limit-spend");
const limitRemain = document.querySelector("#limit-remain");
const expenseCategorySelected = document.querySelector("#expenseCategory");
const typeMoneyToSpend = document.querySelector("#expenseAmount");
const showLimitField = document.querySelector("#show-limit");
const dateSelected = document.querySelector("#todays-date");

//api
const getLimitForCategory = async (category) => {
  try {
    const res = await fetch(`../api/limit/${category}`);
    return (data = await res.json());
  } catch (e) {
    console.log("ERROR", e);
  }
};

const getMonthlySumForCategory = async (category, date) => {
  try {
    const res = await fetch(`../api/monthlySum/${category}/${date}`);
    return (data = await res.json());
  } catch (e) {
    console.log("ERROR", e);
  }
};

//const function assignment
const showLimitForCategory = async (limitToBeShown) => {
  putLimit.innerHTML =
    "Miesięczny limit wybranej kategorii: " + limitToBeShown + " zł";
};

const showMonthlyMoneySpendForCategory = async (moneySpendInSelectedMonth) => {
  if (moneySpendInSelectedMonth === null) {
    limitSpend.innerHTML = "Misięczna suma wydatków: " + 0 + " zł";
  } else {
    limitSpend.innerHTML =
      "Misięczna suma wydatków: " + moneySpendInSelectedMonth + " zł";
  }
};

const showLimitBalancePlusOrMinus = (
  moneyRemainToSpendInCategory,
  limitRemain
) => {
  if (moneyRemainToSpendInCategory >= 0) {
    limitRemain.classList.remove("limitRemainMinus");
    limitRemain.classList.add("limitRemainPlus");
  } else {
    limitRemain.classList.remove("limitRemainPlus");
    limitRemain.classList.add("limitRemainMinus");
  }
};

const showMoneyRemainForCategory = async (
  limitToBeShown,
  moneySpendInSelectedMonth
) => {
  let moneyRemainToSpendInCategory = (
    limitToBeShown - moneySpendInSelectedMonth
  ).toFixed(2);

  showLimitBalancePlusOrMinus(moneyRemainToSpendInCategory, limitRemain);

  limitRemain.innerHTML =
    "Pozostało do wydania: " + moneyRemainToSpendInCategory + " zł";
};

//event listeners
expenseCategorySelected.addEventListener("change", async (e) => {
  e.preventDefault();

  const category = expenseCategorySelected.value;
  const date = dateSelected.value;

  const limitToBeShown = await getLimitForCategory(category);
  const moneySpendInSelectedMonth = await getMonthlySumForCategory(
    category,
    date
  );

  showLimitField.style.display = "block";

  if (limitToBeShown === null) {
    putLimit.innerHTML = "Nie ustawiono limitu dla wybranej kategorii";
    limitSpend.style.display = "none";
    limitRemain.style.display = "none";
  } else {
    limitSpend.style.display = "block";
    limitRemain.style.display = "block";
    showLimitForCategory(limitToBeShown);
    showMonthlyMoneySpendForCategory(moneySpendInSelectedMonth);
    showMoneyRemainForCategory(limitToBeShown, moneySpendInSelectedMonth);
  }
});

typeMoneyToSpend.addEventListener("keyup", async (e) => {
  e.preventDefault();

  const moneyValueTyped = typeMoneyToSpend.value;
  const category = expenseCategorySelected.value;
  const date = dateSelected.value;
  const limitToBeShown = await getLimitForCategory(category);
  const moneySpendInSelectedMonth = await getMonthlySumForCategory(
    category,
    date
  );

  let moneyRemainToSpendInCategory = (
    limitToBeShown - moneySpendInSelectedMonth
  ).toFixed(2);

  let moneySpendBalance = (
    moneyRemainToSpendInCategory - moneyValueTyped
  ).toFixed(2);

  showLimitBalancePlusOrMinus(moneySpendBalance, limitRemain);

  limitRemain.innerHTML = "Pozostało do wydania: " + moneySpendBalance + " zł";
});

$("#datepicker")
  .datepicker()
  .on("change", async (e) => {
    e.preventDefault();

    const category = expenseCategorySelected.value;
    const date = dateSelected.value;

    const limitToBeShown = await getLimitForCategory(category);
    const moneySpendInSelectedMonth = await getMonthlySumForCategory(
      category,
      date
    );

    if (category === "") {
      showLimitField.style.display = "none";
    } else {
      showLimitField.style.display = "block";

      if (limitToBeShown === null) {
        putLimit.innerHTML = "Nie ustawiono limitu dla wybranej kategorii";
        limitSpend.style.display = "none";
        limitRemain.style.display = "none";
      } else {
        limitSpend.style.display = "block";
        limitRemain.style.display = "block";
        showLimitForCategory(limitToBeShown);
        showMonthlyMoneySpendForCategory(moneySpendInSelectedMonth);
        showMoneyRemainForCategory(limitToBeShown, moneySpendInSelectedMonth);
      }
    }
  });
