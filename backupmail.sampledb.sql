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
CREATE TABLE `igw_adm` (
  `id_adm` int(10) NOT NULL,
  `id_member` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `tlf` varchar(15) NOT NULL,
  `tlf_movil` varchar(15) NOT NULL,
  `correo` varchar(155) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `igw_adm` (`id_adm`, `id_member`, `nombre`, `apellidos`, `tlf`, `tlf_movil`, `correo`) VALUES
(1, 1, 'Admin', 'BackupMail', '000000000', '000000000', 'backupmail@iguannaweb.com');
-- --------------------------------------------------------

CREATE TABLE `igw_members` (
  `id` int(11) NOT NULL,
  `usr` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tipo` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ALM',
  `activo` int(1) NOT NULL DEFAULT '0',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `igw_members` (`id`, `usr`, `pass`, `email`, `tipo`, `activo`, `dt`) VALUES
(1, 'admin', '$2y$10$p8gycOSlpRuKEYntcLIoie8rDyXQbc/FctL0ll.2j4LUV7w6RN1re', 'backupmail@iguannaweb.com', 'ADM', 1, '0000-00-00 00:00:00');
-- --------------------------------------------------------

ALTER TABLE `igw_adm`
  ADD PRIMARY KEY (`id_adm`);

ALTER TABLE `igw_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usr` (`usr`);

ALTER TABLE `igw_adm`
  MODIFY `id_adm` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `igw_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


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
