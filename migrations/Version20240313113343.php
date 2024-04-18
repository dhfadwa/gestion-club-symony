<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313113343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre ADD photo_id INT DEFAULT NULL, ADD file_path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB297E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB297E9E4C8C ON membre (photo_id)');
        $this->addSql('ALTER TABLE photo ADD photo VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB297E9E4C8C');
        $this->addSql('DROP INDEX UNIQ_F6B4FB297E9E4C8C ON membre');
        $this->addSql('ALTER TABLE membre DROP photo_id, DROP file_path');
        $this->addSql('ALTER TABLE photo DROP photo');
    }
}
