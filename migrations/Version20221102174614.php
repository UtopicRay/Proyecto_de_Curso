<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102174614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evento_cronograma (evento_id INT NOT NULL, cronograma_id INT NOT NULL, PRIMARY KEY(evento_id, cronograma_id))');
        $this->addSql('CREATE INDEX IDX_B9D337F387A5F842 ON evento_cronograma (evento_id)');
        $this->addSql('CREATE INDEX IDX_B9D337F3E2AD7CD6 ON evento_cronograma (cronograma_id)');
        $this->addSql('ALTER TABLE evento_cronograma ADD CONSTRAINT FK_B9D337F387A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evento_cronograma ADD CONSTRAINT FK_B9D337F3E2AD7CD6 FOREIGN KEY (cronograma_id) REFERENCES cronograma (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evento DROP CONSTRAINT fk_47860b05e2ad7cd6');
        $this->addSql('DROP INDEX uniq_47860b05e2ad7cd6');
        $this->addSql('ALTER TABLE evento ADD fecha_ini TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE evento ADD fecha_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE evento ADD hora_inic TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE evento ADD hora_fin TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE evento DROP cronograma_id');
        $this->addSql('ALTER TABLE evento DROP cant_part');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DD67CF11D ON usuario (nombre_usuario)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE evento_cronograma DROP CONSTRAINT FK_B9D337F387A5F842');
        $this->addSql('ALTER TABLE evento_cronograma DROP CONSTRAINT FK_B9D337F3E2AD7CD6');
        $this->addSql('DROP TABLE evento_cronograma');
        $this->addSql('ALTER TABLE evento ADD cronograma_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evento ADD cant_part INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evento DROP fecha_ini');
        $this->addSql('ALTER TABLE evento DROP fecha_fin');
        $this->addSql('ALTER TABLE evento DROP hora_inic');
        $this->addSql('ALTER TABLE evento DROP hora_fin');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT fk_47860b05e2ad7cd6 FOREIGN KEY (cronograma_id) REFERENCES cronograma (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_47860b05e2ad7cd6 ON evento (cronograma_id)');
        $this->addSql('DROP INDEX UNIQ_2265B05DD67CF11D');
    }
}
