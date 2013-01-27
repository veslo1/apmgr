/* Issue 223 */
ALTER TABLE paymentDetail
MODIFY paymentType enum('cash','credit card','check','money order') NOT NULL;

DELETE FROM messages WHERE identifier IN ('errorSavingAccountTransaction', 'errorSavingPaymentDetail','errorSavingPayment', 'errorSavingBill' );