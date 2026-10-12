const transactions = [
  { id: 1, user: "Anna", category: "RTV", amount: 1200, status: "completed" },
  { id: 2, user: "Piotr", category: "AGD", amount: 450, status: "pending" },
  { id: 3, user: "Anna", category: "RTV", amount: 300, status: "completed" },
  { id: 4, user: "Jan", category: "AGD", amount: 2100, status: "completed" },
  { id: 5, user: "Piotr", category: "RTV", amount: 150, status: "cancelled" }
];

function analyzeTransactions(data) {
  const result = data.reduce(
    (acc, { user, category, amount, status }) => {
      if (status === "completed") {
        acc.totalCompletedAmount += amount;
        acc.usersSummary[user] = (acc.usersSummary[user] || 0) + amount;
        acc._catSums[category] = (acc._catSums[category] || 0) + amount;

        if (acc._catSums[category] > acc._maxCatAmount) {
          acc._maxCatAmount = acc._catSums[category];
          acc.topCategory = category;
        }
      }
      return acc;
    },
    {
      totalCompletedAmount: 0,
      usersSummary: {},
      topCategory: null,
      _catSums: {},
      _maxCatAmount: 0
    }
  );

  delete result._catSums;
  delete result._maxCatAmount;

  return result;
}