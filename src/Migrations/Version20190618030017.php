<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190618030017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE especialidades (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medicos ADD especialidade_id INT NOT NULL');
        $this->addSql('ALTER TABLE medicos ADD CONSTRAINT FK_645027213BA9BFA5 FOREIGN KEY (especialidade_id) REFERENCES especialidades (id)');
        $this->addSql('CREATE INDEX IDX_645027213BA9BFA5 ON medicos (especialidade_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE medicos DROP FOREIGN KEY FK_645027213BA9BFA5');
        $this->addSql('DROP TABLE especialidades');
        $this->addSql('DROP INDEX IDX_645027213BA9BFA5 ON medicos');
        $this->addSql('ALTER TABLE medicos DROP especialidade_id');
    }
}
