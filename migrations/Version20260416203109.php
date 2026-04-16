<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416203109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assolement ADD culture_id INT NOT NULL, ADD campagne_id INT NOT NULL, DROP culture, DROP parcelle, CHANGE campagne parcelle_id INT NOT NULL');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B0524433ED66 FOREIGN KEY (parcelle_id) REFERENCES parcelle (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B052B108249D FOREIGN KEY (culture_id) REFERENCES culture (id)');
        $this->addSql('ALTER TABLE assolement ADD CONSTRAINT FK_4E02B05216227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id)');
        $this->addSql('CREATE INDEX IDX_4E02B0524433ED66 ON assolement (parcelle_id)');
        $this->addSql('CREATE INDEX IDX_4E02B052B108249D ON assolement (culture_id)');
        $this->addSql('CREATE INDEX IDX_4E02B05216227374 ON assolement (campagne_id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D273B2F034 FOREIGN KEY (assolement_id) REFERENCES assolement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B0524433ED66');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B052B108249D');
        $this->addSql('ALTER TABLE assolement DROP FOREIGN KEY FK_4E02B05216227374');
        $this->addSql('DROP INDEX IDX_4E02B0524433ED66 ON assolement');
        $this->addSql('DROP INDEX IDX_4E02B052B108249D ON assolement');
        $this->addSql('DROP INDEX IDX_4E02B05216227374 ON assolement');
        $this->addSql('ALTER TABLE assolement ADD culture VARCHAR(100) NOT NULL, ADD parcelle VARCHAR(100) NOT NULL, ADD campagne INT NOT NULL, DROP parcelle_id, DROP culture_id, DROP campagne_id');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D273B2F034');
    }
}
