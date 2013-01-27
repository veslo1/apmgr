UPDATE actions
SET icon = NULL
WHERE name = "Createfee";

UPDATE controllers
SET icon = "/images/dashboard/controllerBar/financialModule/fee.png"
WHERE name = "Fee";

UPDATE controllers
SET icon = "/images/dashboard/controllerBar/financialModule/finacctsetting.png"
WHERE name = "Financialaccountsetting";