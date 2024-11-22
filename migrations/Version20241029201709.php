<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241029201709 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receta_repuesto DROP FOREIGN KEY FK_6E70625C54F853F8');
        $this->addSql('ALTER TABLE receta_repuesto DROP FOREIGN KEY FK_6E70625C4C3B689E');
        $this->addSql('DROP TABLE receta_repuesto');
    }
}
