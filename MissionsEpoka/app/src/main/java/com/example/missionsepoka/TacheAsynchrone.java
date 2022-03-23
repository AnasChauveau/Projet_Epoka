package com.example.missionsepoka;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

    public class TacheAsynchrone extends AsyncTask<Void, Integer, String> {

        public String urlServiceWeb;
        public Activity activityApp;

        @Override
        protected String doInBackground(Void... voids) {
            return getServerDataJSON (urlServiceWeb);
        }

        @Override
        protected void onPostExecute (String resultat){
            EcranConnexion.tvResultat.append(resultat); // importe tvResultat de main activity grace au statique
        }


    private String getServerDataJSON(String urlService) {
        String res ="";
        InputStream inputStream = null;

        URL url;
        try {
            url = new URL(urlService);
            HttpURLConnection connexion = (HttpURLConnection)url.openConnection();
            connexion.connect();
            inputStream = connexion.getInputStream();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
            res = bufferedReader.readLine();

            //débodage JSON
            String resultat = "";
            JSONArray jsonArray = new JSONArray(res);
            JSONObject jsonObject = jsonArray.getJSONObject(0);
            Salarie salarie = new Salarie();
            salarie.prenom = jsonObject.getString("prenomSal");
            salarie.nom = jsonObject.getString("nomSal");
            salarie.identifiant = jsonObject.getString("identifiant");
            if(jsonObject.getString("err").equals("1")){
                resultat = jsonObject.getString("erreur");
            }else {
                Intent intent = new Intent(activityApp.getApplicationContext(),EcranAccueil.class);
                intent.setFlags((Intent.FLAG_ACTIVITY_CLEAR_TASK+Intent.FLAG_ACTIVITY_NEW_TASK));
                activityApp.startActivity(intent);
                activityApp.overridePendingTransition(android.R.anim.fade_in,android.R.anim.fade_out );
            }

            return resultat;

        } catch (Exception e) {
            Toast.makeText(activityApp ,"erreur : " + e.getLocalizedMessage(), Toast.LENGTH_SHORT);
        }
        return res;
    }

    class Salarie{
        private String prenom = "";
        private String nom = "" ;
        private String identifiant = "";

        public void setSalarie(String nom,String prenom,String identifiant){
            this.prenom = prenom;
            this.nom = nom;
            this.identifiant = identifiant;
        }

        public String getSalarie(){

        }
    }

}
