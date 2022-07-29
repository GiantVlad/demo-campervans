<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726182228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        $this->addSql('CREATE SEQUENCE item_station_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE items_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE orders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE stations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_station (id INT NOT NULL, item_id INT DEFAULT NULL, station_id INT DEFAULT NULL, last_date DATE NOT NULL DEFAULT CURRENT_DATE, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9464DEE5126F525E ON item_station (item_id)');
        $this->addSql('CREATE INDEX IDX_9464DEE521BDB235 ON item_station (station_id)');
        $this->addSql('CREATE TABLE items (id INT NOT NULL, type VARCHAR(255) NOT NULL, uuid UUID NOT NULL DEFAULT uuid_generate_v4(), alias VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E11EE94DD17F50A6 ON items (uuid)');
        $this->addSql('COMMENT ON COLUMN items.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE order_item (id INT NOT NULL, order_id INT DEFAULT NULL, item_id INT DEFAULT NULL, in_station_id INT DEFAULT NULL, out_station_id INT DEFAULT NULL, date_from DATE NOT NULL DEFAULT CURRENT_DATE, date_to DATE NOT NULL DEFAULT CURRENT_DATE, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EA1F098D9F6D38 ON order_item (order_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09126F525E ON order_item (item_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F096E00DA83 ON order_item (in_station_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09A214C4A5 ON order_item (out_station_id)');
        $this->addSql('CREATE TABLE orders (id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE stations (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE item_station ADD CONSTRAINT FK_9464DEE5126F525E FOREIGN KEY (item_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_station ADD CONSTRAINT FK_9464DEE521BDB235 FOREIGN KEY (station_id) REFERENCES stations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09126F525E FOREIGN KEY (item_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F096E00DA83 FOREIGN KEY (in_station_id) REFERENCES stations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09A214C4A5 FOREIGN KEY (out_station_id) REFERENCES stations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item_station DROP CONSTRAINT FK_9464DEE5126F525E');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F09126F525E');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE item_station DROP CONSTRAINT FK_9464DEE521BDB235');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F096E00DA83');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F09A214C4A5');
        $this->addSql('DROP SEQUENCE item_station_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE items_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE order_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE orders_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE stations_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE item_station');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE stations');
    }
}
