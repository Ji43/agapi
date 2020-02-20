<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131093422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie_produit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_couverture VARCHAR(255) DEFAULT NULL, courte_introduction VARCHAR(255) NOT NULL, courte_description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, sous_categorie_produit_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, slug VARCHAR(255) NOT NULL, parfume TINYINT(1) DEFAULT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27963D34DE (sous_categorie_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie_produit (id INT AUTO_INCREMENT NOT NULL, categorie_produit_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, has_nature_parfume TINYINT(1) NOT NULL, image_couverture VARCHAR(255) NOT NULL, courte_description VARCHAR(255) NOT NULL, courte_introduction VARCHAR(255) NOT NULL, INDEX IDX_B703977291FDB457 (categorie_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27963D34DE FOREIGN KEY (sous_categorie_produit_id) REFERENCES sous_categorie_produit (id)');
        $this->addSql('ALTER TABLE sous_categorie_produit ADD CONSTRAINT FK_B703977291FDB457 FOREIGN KEY (categorie_produit_id) REFERENCES categorie_produit (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sous_categorie_produit DROP FOREIGN KEY FK_B703977291FDB457');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27963D34DE');
        $this->addSql('DROP TABLE categorie_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE sous_categorie_produit');
    }
}
