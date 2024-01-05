-- MIT License
--
-- Copyright (c) 2024 DjCtavia
--
-- Permission is hereby granted, free of charge, to any person obtaining a copy
-- of this software and associated documentation files (the "Software"), to deal
-- in the Software without restriction, including without limitation the rights
-- to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
-- copies of the Software, and to permit persons to whom the Software is
-- furnished to do so, subject to the following conditions:
--
-- The above copyright notice and this permission notice shall be included in all
-- copies or substantial portions of the Software.
--
-- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
-- IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
-- FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
-- AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
-- LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
-- OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
-- SOFTWARE.

CREATE
    DATABASE IF NOT EXISTS ip_monitoring
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE
    ip_monitoring;

CREATE TABLE IF NOT EXISTS `ip_address`
(
    id          INT AUTO_INCREMENT PRIMARY KEY     NOT NULL,
    ip_address  VARCHAR(255) UNIQUE                NOT NULL,
    ip_type     VARCHAR(255)                       NOT NULL,
    description TEXT,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS `group`
(
    id         INT AUTO_INCREMENT PRIMARY KEY     NOT NULL,
    name       VARCHAR(255)                       NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS `ip_list_group`
(
    ip_address_id INT,
    group_id      INT,
    PRIMARY KEY (ip_address_id, group_id),
    FOREIGN KEY (ip_address_id) REFERENCES ip_address (id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ip_monitoring_status
(
    id            INT AUTO_INCREMENT PRIMARY KEY     NOT NULL,
    ip_address_id INT,
    ping_status   BOOLEAN,
    timestamp     DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (ip_address_id) REFERENCES ip_address (id) ON DELETE CASCADE
);