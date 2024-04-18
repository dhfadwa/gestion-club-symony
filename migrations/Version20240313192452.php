<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313192452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_membre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(300) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, description VARCHAR(300) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_B8EE387212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, club_id INT NOT NULL, category_id INT NOT NULL, photo_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, niveau VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, INDEX IDX_F6B4FB2961190A32 (club_id), INDEX IDX_F6B4FB2912469DE2 (category_id), UNIQUE INDEX UNIQ_F6B4FB297E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE387212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2961190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB2912469DE2 FOREIGN KEY (category_id) REFERENCES categorie_membre (id)');
        $this->addSql('ALTER TABLE membre ADD CONSTRAINT FK_F6B4FB297E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE387212469DE2');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2961190A32');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB2912469DE2');
        $this->addSql('ALTER TABLE membre DROP FOREIGN KEY FK_F6B4FB297E9E4C8C');
        $this->addSql('DROP TABLE categorie_membre');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE photo');
    }
}
