<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727050059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE item_types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_types (id INT NOT NULL, type VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_739792E08CDE5729 ON item_types (type)');
        $this->addSql('ALTER TABLE items ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE items DROP type');
        $this->addSql('ALTER TABLE items DROP alias');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DC54C8C93 FOREIGN KEY (type_id) REFERENCES item_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E11EE94DC54C8C93 ON items (type_id)');
        $this->addSql('CREATE unique index unique_item_date ON item_station (last_date, item_id)');
        // alter table order_item add item_type_id int not null;
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE items DROP CONSTRAINT FK_E11EE94DC54C8C93');
        $this->addSql('DROP SEQUENCE item_types_id_seq CASCADE');
        $this->addSql('DROP TABLE item_types');
        $this->addSql('DROP INDEX IDX_E11EE94DC54C8C93');
        $this->addSql('ALTER TABLE items ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE items ADD alias VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE items DROP type_id');
        $this->addSql('ALTER TABLE items ALTER uuid SET DEFAULT \'uuid_generate_v4()\'');
    }
}
