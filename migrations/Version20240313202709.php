<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313202709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE club CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE387212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE387212469DE2');
        $this->addSql('ALTER TABLE club CHANGE description description VARCHAR(300) NOT NULL');
    }
}
