<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203151148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cardiovasculaire (id INT AUTO_INCREMENT NOT NULL, tabac VARCHAR(255) DEFAULT NULL, activite_physique VARCHAR(255) DEFAULT NULL, alimentation LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cardiovasculaire_qcm_facteurs (facteurs_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_958389EA41CEFF1D (facteurs_id), UNIQUE INDEX UNIQ_958389EAFF6241A6 (qcm_id), PRIMARY KEY(facteurs_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cardiovasculaire_qcm_traitement (traitement_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_97BB5F37DDA344B6 (traitement_id), UNIQUE INDEX UNIQ_97BB5F37FF6241A6 (qcm_id), PRIMARY KEY(traitement_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deces (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, cause_principale VARCHAR(255) DEFAULT NULL, codage_principal INT DEFAULT NULL, cause_secondaire VARCHAR(255) DEFAULT NULL, codage_secondaire INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donnee (id INT AUTO_INCREMENT NOT NULL, date_visite DATE DEFAULT NULL, recidive VARCHAR(255) DEFAULT NULL, date_survenue DATE DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, dyspnee INT DEFAULT NULL, douleur INT DEFAULT NULL, tabac VARCHAR(255) DEFAULT NULL, activite VARCHAR(255) DEFAULT NULL, alimentation LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', crp NUMERIC(10, 2) DEFAULT NULL, hemoglobine NUMERIC(10, 1) DEFAULT NULL, leucocytes NUMERIC(10, 2) DEFAULT NULL, pnn NUMERIC(10, 2) DEFAULT NULL, plaquettes NUMERIC(10, 1) DEFAULT NULL, cholesterol NUMERIC(10, 2) DEFAULT NULL, ldl NUMERIC(10, 2) DEFAULT NULL, hdl NUMERIC(10, 2) DEFAULT NULL, hba1c NUMERIC(10, 1) DEFAULT NULL, il1_b NUMERIC(10, 2) DEFAULT NULL, il6 NUMERIC(10, 2) DEFAULT NULL, il10 NUMERIC(10, 2) DEFAULT NULL, il18 NUMERIC(10, 2) DEFAULT NULL, tnfa NUMERIC(10, 2) DEFAULT NULL, creatininemie INT DEFAULT NULL, hematopoiese VARCHAR(255) DEFAULT NULL, number_of_mutation INT DEFAULT NULL, carotide_commune_droite INT DEFAULT NULL, carotide_commune_droite_done TINYINT(1) DEFAULT NULL, carotide_commune_gauche INT DEFAULT NULL, carotide_commune_gauche_done TINYINT(1) DEFAULT NULL, carotide_interne_droite INT DEFAULT NULL, carotide_interne_droite_done TINYINT(1) DEFAULT NULL, carotide_interne_gauche INT DEFAULT NULL, carotide_interne_gauche_done TINYINT(1) DEFAULT NULL, fraction INT DEFAULT NULL, fraction_done TINYINT(1) DEFAULT NULL, stenoses VARCHAR(255) DEFAULT NULL, ips VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donnee_qcm_facteurs (facteurs_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_F9FC617E41CEFF1D (facteurs_id), UNIQUE INDEX UNIQ_F9FC617EFF6241A6 (qcm_id), PRIMARY KEY(facteurs_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donnee_qcm_traitement (traitement_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_2C47161CDDA344B6 (traitement_id), UNIQUE INDEX UNIQ_2C47161CFF6241A6 (qcm_id), PRIMARY KEY(traitement_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donnee_gene (donnee_id INT NOT NULL, gene_id INT NOT NULL, INDEX IDX_EF19532AC310CCAD (donnee_id), INDEX IDX_EF19532A38BEE1C3 (gene_id), PRIMARY KEY(donnee_id, gene_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE erreur (id INT AUTO_INCREMENT NOT NULL, participant_id INT DEFAULT NULL, date_creation DATETIME NOT NULL, message VARCHAR(1023) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, field_id VARCHAR(255) DEFAULT NULL, utilisateur VARCHAR(255) DEFAULT NULL, INDEX IDX_980709A9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gene (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, mutation VARCHAR(255) DEFAULT NULL, frequence INT DEFAULT NULL, classification VARCHAR(255) DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `general` (id INT AUTO_INCREMENT NOT NULL, age INT DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, date_naissance DATE DEFAULT NULL, taille INT DEFAULT NULL, poids INT DEFAULT NULL, imc NUMERIC(10, 1) DEFAULT NULL, systolique INT DEFAULT NULL, diastolique INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, date_survenue DATETIME DEFAULT NULL, traitement_phase_aigue LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', crp NUMERIC(10, 2) DEFAULT NULL, hemoglobine NUMERIC(10, 1) DEFAULT NULL, leucocytes NUMERIC(10, 2) DEFAULT NULL, pnn NUMERIC(10, 2) DEFAULT NULL, plaquettes NUMERIC(10, 1) DEFAULT NULL, cholesterol NUMERIC(10, 2) DEFAULT NULL, ldlc NUMERIC(10, 2) DEFAULT NULL, hdlc NUMERIC(10, 2) DEFAULT NULL, hb_a1c NUMERIC(10, 1) DEFAULT NULL, creatininemie INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information_qcm_type (type_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_9B2046C6C54C8C93 (type_id), UNIQUE INDEX UNIQ_9B2046C6FF6241A6 (qcm_id), PRIMARY KEY(type_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information_qcm_complications (complications_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_C30E0677154025A7 (complications_id), UNIQUE INDEX UNIQ_C30E0677FF6241A6 (qcm_id), PRIMARY KEY(complications_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, verification_id INT DEFAULT NULL, general_id INT DEFAULT NULL, cardiovasculaire_id INT DEFAULT NULL, information_id INT DEFAULT NULL, donnee_id INT DEFAULT NULL, suivi_id INT DEFAULT NULL, deces_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, validation TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_D79F6B111623CB0A (verification_id), UNIQUE INDEX UNIQ_D79F6B11D0E2C4F1 (general_id), UNIQUE INDEX UNIQ_D79F6B1174E0D702 (cardiovasculaire_id), UNIQUE INDEX UNIQ_D79F6B112EF03101 (information_id), UNIQUE INDEX UNIQ_D79F6B11C310CCAD (donnee_id), UNIQUE INDEX UNIQ_D79F6B117FEA59C0 (suivi_id), UNIQUE INDEX UNIQ_D79F6B11D73584F3 (deces_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_utilisateur (participant_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_E72F9E369D1C3019 (participant_id), INDEX IDX_E72F9E36FB88E14F (utilisateur_id), PRIMARY KEY(participant_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qcm (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, reponse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivi (id INT AUTO_INCREMENT NOT NULL, event VARCHAR(255) DEFAULT NULL, event_date DATE DEFAULT NULL, cause VARCHAR(255) DEFAULT NULL, aucun_evenement TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE verification (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE verification_qcm_inclusion (inclusion_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_F604B74C35B9755 (inclusion_id), UNIQUE INDEX UNIQ_F604B74CFF6241A6 (qcm_id), PRIMARY KEY(inclusion_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE verification_qcm_non_inclusion (non_inclusion_id INT NOT NULL, qcm_id INT NOT NULL, INDEX IDX_40DEA62CF2FCDFD0 (non_inclusion_id), UNIQUE INDEX UNIQ_40DEA62CFF6241A6 (qcm_id), PRIMARY KEY(non_inclusion_id, qcm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_facteurs ADD CONSTRAINT FK_958389EA41CEFF1D FOREIGN KEY (facteurs_id) REFERENCES cardiovasculaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_facteurs ADD CONSTRAINT FK_958389EAFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_traitement ADD CONSTRAINT FK_97BB5F37DDA344B6 FOREIGN KEY (traitement_id) REFERENCES cardiovasculaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_traitement ADD CONSTRAINT FK_97BB5F37FF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donnee_qcm_facteurs ADD CONSTRAINT FK_F9FC617E41CEFF1D FOREIGN KEY (facteurs_id) REFERENCES donnee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donnee_qcm_facteurs ADD CONSTRAINT FK_F9FC617EFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donnee_qcm_traitement ADD CONSTRAINT FK_2C47161CDDA344B6 FOREIGN KEY (traitement_id) REFERENCES donnee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donnee_qcm_traitement ADD CONSTRAINT FK_2C47161CFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donnee_gene ADD CONSTRAINT FK_EF19532AC310CCAD FOREIGN KEY (donnee_id) REFERENCES donnee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donnee_gene ADD CONSTRAINT FK_EF19532A38BEE1C3 FOREIGN KEY (gene_id) REFERENCES gene (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE erreur ADD CONSTRAINT FK_980709A9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE information_qcm_type ADD CONSTRAINT FK_9B2046C6C54C8C93 FOREIGN KEY (type_id) REFERENCES information (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE information_qcm_type ADD CONSTRAINT FK_9B2046C6FF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE information_qcm_complications ADD CONSTRAINT FK_C30E0677154025A7 FOREIGN KEY (complications_id) REFERENCES information (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE information_qcm_complications ADD CONSTRAINT FK_C30E0677FF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B111623CB0A FOREIGN KEY (verification_id) REFERENCES verification (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11D0E2C4F1 FOREIGN KEY (general_id) REFERENCES `general` (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1174E0D702 FOREIGN KEY (cardiovasculaire_id) REFERENCES cardiovasculaire (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B112EF03101 FOREIGN KEY (information_id) REFERENCES information (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11C310CCAD FOREIGN KEY (donnee_id) REFERENCES donnee (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B117FEA59C0 FOREIGN KEY (suivi_id) REFERENCES suivi (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11D73584F3 FOREIGN KEY (deces_id) REFERENCES deces (id)');
        $this->addSql('ALTER TABLE participant_utilisateur ADD CONSTRAINT FK_E72F9E369D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_utilisateur ADD CONSTRAINT FK_E72F9E36FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE verification_qcm_inclusion ADD CONSTRAINT FK_F604B74C35B9755 FOREIGN KEY (inclusion_id) REFERENCES verification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE verification_qcm_inclusion ADD CONSTRAINT FK_F604B74CFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE verification_qcm_non_inclusion ADD CONSTRAINT FK_40DEA62CF2FCDFD0 FOREIGN KEY (non_inclusion_id) REFERENCES verification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE verification_qcm_non_inclusion ADD CONSTRAINT FK_40DEA62CFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_facteurs DROP FOREIGN KEY FK_958389EA41CEFF1D');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_facteurs DROP FOREIGN KEY FK_958389EAFF6241A6');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_traitement DROP FOREIGN KEY FK_97BB5F37DDA344B6');
        $this->addSql('ALTER TABLE cardiovasculaire_qcm_traitement DROP FOREIGN KEY FK_97BB5F37FF6241A6');
        $this->addSql('ALTER TABLE donnee_qcm_facteurs DROP FOREIGN KEY FK_F9FC617E41CEFF1D');
        $this->addSql('ALTER TABLE donnee_qcm_facteurs DROP FOREIGN KEY FK_F9FC617EFF6241A6');
        $this->addSql('ALTER TABLE donnee_qcm_traitement DROP FOREIGN KEY FK_2C47161CDDA344B6');
        $this->addSql('ALTER TABLE donnee_qcm_traitement DROP FOREIGN KEY FK_2C47161CFF6241A6');
        $this->addSql('ALTER TABLE donnee_gene DROP FOREIGN KEY FK_EF19532AC310CCAD');
        $this->addSql('ALTER TABLE donnee_gene DROP FOREIGN KEY FK_EF19532A38BEE1C3');
        $this->addSql('ALTER TABLE erreur DROP FOREIGN KEY FK_980709A9D1C3019');
        $this->addSql('ALTER TABLE information_qcm_type DROP FOREIGN KEY FK_9B2046C6C54C8C93');
        $this->addSql('ALTER TABLE information_qcm_type DROP FOREIGN KEY FK_9B2046C6FF6241A6');
        $this->addSql('ALTER TABLE information_qcm_complications DROP FOREIGN KEY FK_C30E0677154025A7');
        $this->addSql('ALTER TABLE information_qcm_complications DROP FOREIGN KEY FK_C30E0677FF6241A6');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B111623CB0A');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11D0E2C4F1');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1174E0D702');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B112EF03101');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11C310CCAD');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B117FEA59C0');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11D73584F3');
        $this->addSql('ALTER TABLE participant_utilisateur DROP FOREIGN KEY FK_E72F9E369D1C3019');
        $this->addSql('ALTER TABLE participant_utilisateur DROP FOREIGN KEY FK_E72F9E36FB88E14F');
        $this->addSql('ALTER TABLE verification_qcm_inclusion DROP FOREIGN KEY FK_F604B74C35B9755');
        $this->addSql('ALTER TABLE verification_qcm_inclusion DROP FOREIGN KEY FK_F604B74CFF6241A6');
        $this->addSql('ALTER TABLE verification_qcm_non_inclusion DROP FOREIGN KEY FK_40DEA62CF2FCDFD0');
        $this->addSql('ALTER TABLE verification_qcm_non_inclusion DROP FOREIGN KEY FK_40DEA62CFF6241A6');
        $this->addSql('DROP TABLE cardiovasculaire');
        $this->addSql('DROP TABLE cardiovasculaire_qcm_facteurs');
        $this->addSql('DROP TABLE cardiovasculaire_qcm_traitement');
        $this->addSql('DROP TABLE deces');
        $this->addSql('DROP TABLE donnee');
        $this->addSql('DROP TABLE donnee_qcm_facteurs');
        $this->addSql('DROP TABLE donnee_qcm_traitement');
        $this->addSql('DROP TABLE donnee_gene');
        $this->addSql('DROP TABLE erreur');
        $this->addSql('DROP TABLE gene');
        $this->addSql('DROP TABLE `general`');
        $this->addSql('DROP TABLE information');
        $this->addSql('DROP TABLE information_qcm_type');
        $this->addSql('DROP TABLE information_qcm_complications');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_utilisateur');
        $this->addSql('DROP TABLE qcm');
        $this->addSql('DROP TABLE suivi');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE verification');
        $this->addSql('DROP TABLE verification_qcm_inclusion');
        $this->addSql('DROP TABLE verification_qcm_non_inclusion');
    }
}
