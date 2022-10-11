<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220925220644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cronograma_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE evento_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE investigacion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE usuario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cronograma (id INT NOT NULL, tema VARCHAR(255) DEFAULT NULL, catedra VARCHAR(255) NOT NULL, fecha_ini DATE NOT NULL, fecha_fin DATE NOT NULL, hora_inic TIME(0) WITHOUT TIME ZONE NOT NULL, hora_final TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE evento (id INT NOT NULL, cronograma_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, tematica VARCHAR(255) NOT NULL, cant_part INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_47860B05E2AD7CD6 ON evento (cronograma_id)');
        $this->addSql('CREATE TABLE evento_investigacion (evento_id INT NOT NULL, investigacion_id INT NOT NULL, PRIMARY KEY(evento_id, investigacion_id))');
        $this->addSql('CREATE INDEX IDX_B2D8B20C87A5F842 ON evento_investigacion (evento_id)');
        $this->addSql('CREATE INDEX IDX_B2D8B20C7E1D61C7 ON evento_investigacion (investigacion_id)');
        $this->addSql('CREATE TABLE investigacion (id INT NOT NULL, titulo VARCHAR(255) NOT NULL, facultad INT NOT NULL, catedra VARCHAR(255) NOT NULL, puntuacion VARCHAR(255) DEFAULT NULL, archivo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE usuario (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, nombre_usuario VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
        $this->addSql('CREATE TABLE usuario_investigacion (usuario_id INT NOT NULL, investigacion_id INT NOT NULL, PRIMARY KEY(usuario_id, investigacion_id))');
        $this->addSql('CREATE INDEX IDX_F8D8FB5EDB38439E ON usuario_investigacion (usuario_id)');
        $this->addSql('CREATE INDEX IDX_F8D8FB5E7E1D61C7 ON usuario_investigacion (investigacion_id)');
        $this->addSql('CREATE TABLE usuario_evento (usuario_id INT NOT NULL, evento_id INT NOT NULL, PRIMARY KEY(usuario_id, evento_id))');
        $this->addSql('CREATE INDEX IDX_BD94E80CDB38439E ON usuario_evento (usuario_id)');
        $this->addSql('CREATE INDEX IDX_BD94E80C87A5F842 ON usuario_evento (evento_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B05E2AD7CD6 FOREIGN KEY (cronograma_id) REFERENCES cronograma (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evento_investigacion ADD CONSTRAINT FK_B2D8B20C87A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE evento_investigacion ADD CONSTRAINT FK_B2D8B20C7E1D61C7 FOREIGN KEY (investigacion_id) REFERENCES investigacion (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario_investigacion ADD CONSTRAINT FK_F8D8FB5EDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario_investigacion ADD CONSTRAINT FK_F8D8FB5E7E1D61C7 FOREIGN KEY (investigacion_id) REFERENCES investigacion (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario_evento ADD CONSTRAINT FK_BD94E80CDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario_evento ADD CONSTRAINT FK_BD94E80C87A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cronograma_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE evento_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE investigacion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE usuario_id_seq CASCADE');
        $this->addSql('ALTER TABLE evento DROP CONSTRAINT FK_47860B05E2AD7CD6');
        $this->addSql('ALTER TABLE evento_investigacion DROP CONSTRAINT FK_B2D8B20C87A5F842');
        $this->addSql('ALTER TABLE evento_investigacion DROP CONSTRAINT FK_B2D8B20C7E1D61C7');
        $this->addSql('ALTER TABLE usuario_investigacion DROP CONSTRAINT FK_F8D8FB5EDB38439E');
        $this->addSql('ALTER TABLE usuario_investigacion DROP CONSTRAINT FK_F8D8FB5E7E1D61C7');
        $this->addSql('ALTER TABLE usuario_evento DROP CONSTRAINT FK_BD94E80CDB38439E');
        $this->addSql('ALTER TABLE usuario_evento DROP CONSTRAINT FK_BD94E80C87A5F842');
        $this->addSql('DROP TABLE cronograma');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE evento_investigacion');
        $this->addSql('DROP TABLE investigacion');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuario_investigacion');
        $this->addSql('DROP TABLE usuario_evento');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
