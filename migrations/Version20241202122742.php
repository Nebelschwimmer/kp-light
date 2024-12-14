<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241202122742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person_film_specialty (id SERIAL NOT NULL, person_id INT DEFAULT NULL, film_id INT DEFAULT NULL, specialty_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3177C8E1217BBB47 ON person_film_specialty (person_id)');
        $this->addSql('CREATE INDEX IDX_3177C8E1567F5183 ON person_film_specialty (film_id)');
        $this->addSql('CREATE INDEX IDX_3177C8E19A353316 ON person_film_specialty (specialty_id)');
        $this->addSql('ALTER TABLE person_film_specialty ADD CONSTRAINT FK_3177C8E1217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_film_specialty ADD CONSTRAINT FK_3177C8E1567F5183 FOREIGN KEY (film_id) REFERENCES film (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_film_specialty ADD CONSTRAINT FK_3177C8E19A353316 FOREIGN KEY (specialty_id) REFERENCES specialty (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE phinxlog');
        $this->addSql('CREATE SEQUENCE film_id_seq');
        $this->addSql('SELECT setval(\'film_id_seq\', (SELECT MAX(id) FROM film))');
        $this->addSql('ALTER TABLE film ALTER id SET DEFAULT nextval(\'film_id_seq\')');
        $this->addSql('ALTER TABLE film ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE film ALTER release_year TYPE INT');
        $this->addSql('ALTER TABLE film ALTER release_year SET NOT NULL');
        $this->addSql('ALTER TABLE film ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE film ALTER rating SET NOT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE224296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22899FB366 FOREIGN KEY (director_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8244BE224296D31F ON film (genre_id)');
        $this->addSql('CREATE INDEX IDX_8244BE22899FB366 ON film (director_id)');
        $this->addSql('ALTER TABLE film_person ADD CONSTRAINT FK_5F2EEC7C567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE film_person ADD CONSTRAINT FK_5F2EEC7C217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5F2EEC7C567F5183 ON film_person (film_id)');
        $this->addSql('CREATE INDEX IDX_5F2EEC7C217BBB47 ON film_person (person_id)');
        $this->addSql('CREATE SEQUENCE genre_id_seq');
        $this->addSql('SELECT setval(\'genre_id_seq\', (SELECT MAX(id) FROM genre))');
        $this->addSql('ALTER TABLE genre ALTER id SET DEFAULT nextval(\'genre_id_seq\')');
        $this->addSql('ALTER TABLE genre ALTER name SET NOT NULL');
        $this->addSql('CREATE SEQUENCE person_id_seq');
        $this->addSql('SELECT setval(\'person_id_seq\', (SELECT MAX(id) FROM person))');
        $this->addSql('ALTER TABLE person ALTER id SET DEFAULT nextval(\'person_id_seq\')');
        $this->addSql('ALTER TABLE person ALTER lastname SET NOT NULL');
        $this->addSql('ALTER TABLE person ALTER firstname SET NOT NULL');
        $this->addSql('ALTER TABLE person ALTER gender SET NOT NULL');
        $this->addSql('ALTER TABLE person ALTER birthday SET NOT NULL');
        $this->addSql('CREATE SEQUENCE specialty_id_seq');
        $this->addSql('SELECT setval(\'specialty_id_seq\', (SELECT MAX(id) FROM specialty))');
        $this->addSql('ALTER TABLE specialty ALTER id SET DEFAULT nextval(\'specialty_id_seq\')');
        $this->addSql('ALTER TABLE specialty ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE specialty_person ADD CONSTRAINT FK_6A7CBB09A353316 FOREIGN KEY (specialty_id) REFERENCES specialty (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE specialty_person ADD CONSTRAINT FK_6A7CBB0217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6A7CBB09A353316 ON specialty_person (specialty_id)');
        $this->addSql('CREATE INDEX IDX_6A7CBB0217BBB47 ON specialty_person (person_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE phinxlog (version BIGINT NOT NULL, migration_name VARCHAR(100) DEFAULT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, breakpoint BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(version))');
        $this->addSql('ALTER TABLE person_film_specialty DROP CONSTRAINT FK_3177C8E1217BBB47');
        $this->addSql('ALTER TABLE person_film_specialty DROP CONSTRAINT FK_3177C8E1567F5183');
        $this->addSql('ALTER TABLE person_film_specialty DROP CONSTRAINT FK_3177C8E19A353316');
        $this->addSql('DROP TABLE person_film_specialty');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE224296D31F');
        $this->addSql('ALTER TABLE film DROP CONSTRAINT FK_8244BE22899FB366');
        $this->addSql('DROP INDEX IDX_8244BE224296D31F');
        $this->addSql('DROP INDEX IDX_8244BE22899FB366');
        $this->addSql('ALTER TABLE film ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE film ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE film ALTER release_year TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE film ALTER release_year DROP NOT NULL');
        $this->addSql('ALTER TABLE film ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE film ALTER rating DROP NOT NULL');
        $this->addSql('ALTER TABLE specialty ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE specialty ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE genre ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE genre ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE specialty_person DROP CONSTRAINT FK_6A7CBB09A353316');
        $this->addSql('ALTER TABLE specialty_person DROP CONSTRAINT FK_6A7CBB0217BBB47');
        $this->addSql('DROP INDEX IDX_6A7CBB09A353316');
        $this->addSql('DROP INDEX IDX_6A7CBB0217BBB47');
        $this->addSql('ALTER TABLE film_person DROP CONSTRAINT FK_5F2EEC7C567F5183');
        $this->addSql('ALTER TABLE film_person DROP CONSTRAINT FK_5F2EEC7C217BBB47');
        $this->addSql('DROP INDEX IDX_5F2EEC7C567F5183');
        $this->addSql('DROP INDEX IDX_5F2EEC7C217BBB47');
        $this->addSql('ALTER TABLE person ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE person ALTER lastname DROP NOT NULL');
        $this->addSql('ALTER TABLE person ALTER firstname DROP NOT NULL');
        $this->addSql('ALTER TABLE person ALTER gender DROP NOT NULL');
        $this->addSql('ALTER TABLE person ALTER birthday DROP NOT NULL');
    }
}
