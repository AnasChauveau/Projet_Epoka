package com.example.missionsepoka;

public class BDD {

    public static class Salarie{
        private String prenom = "";
        private String nom = "";
        private String identifiant = "";

        public void Salarie(String prenom, String nom, String identifiant){
            this.prenom = prenom;
            this.nom = nom;
            this.identifiant = identifiant;
        }

        public String getIdentite(){
            String identite = this.prenom + " " + this.nom;
            return identite;
        }

        public String getIdentifiant(){
            String pseudo = this.identifiant;
            return pseudo;
        }

    }
}
