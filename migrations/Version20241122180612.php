<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241122180612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE receta_repuesto (id INT AUTO_INCREMENT NOT NULL, receta_id INT NOT NULL, repuesto_id INT NOT NULL, cantidad INT NOT NULL, INDEX IDX_6E70625C54F853F8 (receta_id), INDEX IDX_6E70625C4C3B689E (repuesto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE receta_repuesto ADD CONSTRAINT FK_6E70625C54F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id)');
        $this->addSql('ALTER TABLE receta_repuesto ADD CONSTRAINT FK_6E70625C4C3B689E FOREIGN KEY (repuesto_id) REFERENCES repuestos (id)');
        $this->addSql('ALTER TABLE repuestos_receta DROP FOREIGN KEY FK_D52AF92854F853F8');
        $this->addSql('ALTER TABLE repuestos_receta DROP FOREIGN KEY FK_D52AF928F08A380E');
        $this->addSql('DROP TABLE repuestos_receta');
        $this->addSql('ALTER TABLE maquinaria CHANGE años_uso anios_uso INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repuestos ADD stock_minimo INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP nombre, DROP apellido, DROP telefono, DROP direccion');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repuestos_receta (repuestos_id INT NOT NULL, receta_id INT NOT NULL, INDEX IDX_D52AF92854F853F8 (receta_id), INDEX IDX_D52AF928F08A380E (repuestos_id), PRIMARY KEY(repuestos_id, receta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE repuestos_receta ADD CONSTRAINT FK_D52AF92854F853F8 FOREIGN KEY (receta_id) REFERENCES receta (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repuestos_receta ADD CONSTRAINT FK_D52AF928F08A380E FOREIGN KEY (repuestos_id) REFERENCES repuestos (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receta_repuesto DROP FOREIGN KEY FK_6E70625C54F853F8');
        $this->addSql('ALTER TABLE receta_repuesto DROP FOREIGN KEY FK_6E70625C4C3B689E');
        $this->addSql('DROP TABLE receta_repuesto');
        $this->addSql('ALTER TABLE maquinaria CHANGE anios_uso años_uso INT DEFAULT NULL');
        $this->addSql('ALTER TABLE repuestos DROP stock_minimo');
        $this->addSql('ALTER TABLE user ADD nombre VARCHAR(255) DEFAULT NULL, ADD apellido VARCHAR(255) DEFAULT NULL, ADD telefono VARCHAR(255) DEFAULT NULL, ADD direccion VARCHAR(255) DEFAULT NULL');
    }
}
