<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416202051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traitement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, produit VARCHAR(100) NOT NULL, dose VARCHAR(50) NOT NULL, unite VARCHAR(20) NOT NULL, date_traitement DATE NOT NULL, commentaire LONGTEXT DEFAULT NULL, assolement_id INT NOT NULL, INDEX IDX_2A356D273B2F034 (assolement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D273B2F034 FOREIGN KEY (assolement_id) REFERENCES assolement (id)');
        $this->addSql('DROP TABLE traitement_assolement');
        $this->addSql('DROP INDEX IDX_4E02B0524433ED66 ON assolement');
        $this->addSql('DROP INDEX IDX_4E02B052B108249D ON assolement');
        $this->addSql('DROP INDEX IDX_4E02B05216227374 ON assolement');
        $this->addSql('ALTER TABLE assolement ADD culture VARCHAR(100) NOT NULL, ADD parcelle VARCHAR(100) NOT NULL, ADD surface DOUBLE PRECISION NOT NULL, ADD campagne INT NOT NULL, DROP date_semis, DROP date_recolte, DROP parcelle_id, DROP culture_id, DROP campagne_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE traitement_assolement (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, produit VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dose VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, unite VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_traitement DATE NOT NULL, commentaire LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, assolement_id INT NOT NULL, INDEX IDX_AAE7AEBD3B2F034 (assolement_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D273B2F034');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('ALTER TABLE assolement ADD date_semis DATE NOT NULL, ADD date_recolte DATE DEFAULT NULL, ADD culture_id INT NOT NULL, ADD campagne_id INT NOT NULL, DROP culture, DROP parcelle, DROP surface, CHANGE campagne parcelle_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_4E02B0524433ED66 ON assolement (parcelle_id)');
        $this->addSql('CREATE INDEX IDX_4E02B052B108249D ON assolement (culture_id)');
        $this->addSql('CREATE INDEX IDX_4E02B05216227374 ON assolement (campagne_id)');
    }
}
