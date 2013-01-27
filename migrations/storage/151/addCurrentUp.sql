/* add current column to applicantWorkflowStatus  */
ALTER TABLE `applicantWorkflowStatus`
ADD COLUMN `currentStatus` tinyint(1) NOT NULL DEFAULT 0,
ADD INDEX `currentIndex`(`currentStatus`);