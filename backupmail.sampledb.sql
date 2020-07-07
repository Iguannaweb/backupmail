/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (C) 2020 Francisco Gálvez Prada                 *
 * This file is part of the project BackupMail               *
 * Contribute on https://github.com/Iguannaweb/backupmail    *
 *                                                           *
 * BACKUPMAIL                                                * 
 * This is a simple solution to backup all your mails.       *
 * It will organize your mails by account, year, month and   *
 * it will create a separate eml file for every mail.        *
 * It will download the attachments too.                     *
 * Contact: info@iguannaweb.com                              *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

CREATE TABLE `igw_emails` (
  `ID_MAIL` int(10) NOT NULL,
  `MAIL` varchar(255) NOT NULL,
  `UID` varchar(55) NOT NULL,
  `MESSAGE_ID` varchar(55) NOT NULL,
  `UDATE` varchar(55) NOT NULL,
  `SUBJECT` varchar(255) NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `FOLDER` varchar(255) DEFAULT 'INBOX',
  `STATUS` int(1) NOT NULL,
  `ARCHIVE` int(1) NOT NULL DEFAULT '0',
  `DELETED` int(1) NOT NULL DEFAULT '0',
  `UPD_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `igw_emails_tags` (
  `ID_MAIL_TAG` int(10) NOT NULL,
  `ID_MAIL` int(10) NOT NULL,
  `ID_TAG` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `igw_tags` (
  `ID_TAG` int(10) NOT NULL,
  `ID_TAG_SUP` int(3) NOT NULL,
  `MAIL` varchar(255) NOT NULL DEFAULT '0',
  `TAG` varchar(255) NOT NULL,
  `TAG_COLOR` varchar(55) NOT NULL DEFAULT 'info',
  `TAG_ICON` varchar(55) NOT NULL DEFAULT 'tag',
  `STATUS` int(1) NOT NULL DEFAULT '1',
  `POSICION` int(3) NOT NULL,
  `ICON_S` varchar(1) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `igw_tags` (`ID_TAG`, `ID_TAG_SUP`, `MAIL`, `TAG`, `TAG_COLOR`, `TAG_ICON`, `STATUS`, `POSICION`, `ICON_S`) VALUES
(1, 0, '0', 'Star', 'yellow', 'star', 1, 1, ''),
(2, 0, '0', 'Spam', 'inverse', 'thumbs-down', 1, 99, ''),
(3, 0, '0', 'Task', 'warning', 'tasks', 1, 1, '');


ALTER TABLE `igw_emails`
  ADD PRIMARY KEY (`ID_MAIL`);

ALTER TABLE `igw_emails_tags`
  ADD PRIMARY KEY (`ID_MAIL_TAG`);

ALTER TABLE `igw_tags`
  ADD PRIMARY KEY (`ID_TAG`);

ALTER TABLE `igw_emails`
  MODIFY `ID_MAIL` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `igw_emails_tags`
  MODIFY `ID_MAIL_TAG` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `igw_tags`
  MODIFY `ID_TAG` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;
