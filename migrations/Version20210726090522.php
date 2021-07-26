<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726090522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE personne');
        $this->addSql('ALTER TABLE produit ADD patisserie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC271031BC6E FOREIGN KEY (patisserie_id) REFERENCES patisserie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC271031BC6E ON produit (patisserie_id)');
        $this->addSql('ALTER TABLE reclamation CHANGE visible visible INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC271031BC6E');
        $this->addSql('DROP INDEX IDX_29A5EC271031BC6E ON produit');
        $this->addSql('ALTER TABLE produit DROP patisserie_id');
        $this->addSql('ALTER TABLE reclamation CHANGE visible visible INT DEFAULT NULL');
    }
}
