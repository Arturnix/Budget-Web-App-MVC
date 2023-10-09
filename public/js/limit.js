const getLimitForCategory = async (category) => {
  try {
    const res = await fetch(`../api/limit/${category}`);
    const data = await res.json();
    return data;
  } catch (e) {
    console.log("ERROR", e);
  }
};

const getMonthlySumForCategory = async (category) => {
  try {
    const res = await fetch(`../api/monthlySum/${category}`);
    const data = await res.json();
    return data;
  } catch (e) {
    console.log("ERROR", e);
  }
};

const showLimitForCategory = async (expenseCategorySelected) => {
  const putLimit = document.querySelector("#limit");
  putLimit.innerHTML =
    "Miesięczny limit wybranej kategorii: " +
    (await getLimitForCategory(expenseCategorySelected)) +
    " zł";
};

const showMonthlyMoneySpendForCategory = async (expenseCategorySelected) => {
  const limitSpend = document.querySelector("#limit-spend");
  if ((await getMonthlySumForCategory(expenseCategorySelected)) === null) {
    limitSpend.innerHTML = "Misięczna suma wydatków: " + 0 + " zł";
  } else {
    limitSpend.innerHTML =
      "Misięczna suma wydatków: " +
      (await getMonthlySumForCategory(expenseCategorySelected)) +
      " zł";
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

const showMoneyRemainForCategory = async (expenseCategorySelected) => {
  const limitRemain = document.querySelector("#limit-remain");
  let moneyRemainToSpendInCategory = (
    (await getLimitForCategory(expenseCategorySelected)) -
    (await getMonthlySumForCategory(expenseCategorySelected))
  ).toFixed(2);

  showLimitBalancePlusOrMinus(moneyRemainToSpendInCategory, limitRemain);

  limitRemain.innerHTML =
    "Pozostało do wydania: " + moneyRemainToSpendInCategory + " zł";
};

const showLimit = document.querySelector("#expenseCategory");
showLimit.addEventListener("change", async (e) => {
  e.preventDefault();

  const expenseCategorySelected =
    document.querySelector("#expenseCategory").value;

  if ((await getLimitForCategory(expenseCategorySelected)) === null) {
    document.getElementById("show-limit").style.display = "none";
  } else {
    document.getElementById("show-limit").style.display = "block";

    showLimitForCategory(expenseCategorySelected);
    showMonthlyMoneySpendForCategory(expenseCategorySelected);
    showMoneyRemainForCategory(expenseCategorySelected);
  }
});

const typeMoneyToSpend = document.querySelector("#expenseAmount");
typeMoneyToSpend.addEventListener("keyup", async (e) => {
  e.preventDefault();

  const moneyValueTyped = document.querySelector("#expenseAmount").value;

  const expenseCategorySelected =
    document.querySelector("#expenseCategory").value;

  let moneyRemainToSpendInCategory = (
    (await getLimitForCategory(expenseCategorySelected)) -
    (await getMonthlySumForCategory(expenseCategorySelected))
  ).toFixed(2);

  let moneySpendBalance = (
    moneyRemainToSpendInCategory - moneyValueTyped
  ).toFixed(2);

  const limitRemain = document.querySelector("#limit-remain");
  showLimitBalancePlusOrMinus(moneySpendBalance, limitRemain);

  limitRemain.innerHTML = "Pozostało do wydania: " + moneySpendBalance + " zł";
});
