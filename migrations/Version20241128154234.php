<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128154234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repuestos_receta DROP FOREIGN KEY FK_D52AF92854F853F8');
        $this->addSql('ALTER TABLE repuestos_receta DROP FOREIGN KEY FK_D52AF928F08A380E');
        $this->addSql('DROP TABLE repuestos_receta');
        $this->addSql('ALTER TABLE user DROP direccion, DROP nombre, DROP apellido, DROP telefono');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repuestos_receta (repuestos_id INT NOT NULL, receta_id INT NOT NULL, INDEX IDX_D52AF92854F853F8 (receta_id), INDEX IDX_D52AF928F08A380E (repuestos_id), PRIMARY KEY(repuestos_id, receta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE repuestos_receta ADD CONSTRAINT FK_D52AF92854F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repuestos_receta ADD CONSTRAINT FK_D52AF928F08A380E FOREIGN KEY (repuestos_id) REFERENCES repuestos (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD direccion VARCHAR(255) DEFAULT NULL, ADD nombre VARCHAR(255) DEFAULT NULL, ADD apellido VARCHAR(255) DEFAULT NULL, ADD telefono VARCHAR(255) DEFAULT NULL');
    }
}
