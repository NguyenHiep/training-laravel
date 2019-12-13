-- Optimize query for table companies
ALTER TABLE `companies` ENGINE = MyISAM;

-- Add index companies
ALTER TABLE `companies`
ADD INDEX `status_idx`(`status`) USING BTREE;

-- Add index comments
ALTER TABLE `comments`
ADD INDEX `company_id_idx`(`company_id`) USING BTREE,
ADD INDEX `status_idx`(`status`) USING BTREE;

-- Add index comments_reply
ALTER TABLE `comments_reply`
ADD INDEX `status_idx`(`status`) USING BTREE;

-- Add index for search name companies
ALTER TABLE `companies` ADD INDEX(name(50)) USING BTREE;
