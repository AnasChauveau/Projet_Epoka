package com.example.missionsepoka;

import android.app.Activity;
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
            String ligne;
            while ((ligne = bufferedReader.readLine()) != null) {
                res += ligne + "\n"; //
                // données délimités par "\n" dans php, ici "\n" permet le saut à la ligne

                //débodage JSON
                String resultat = "";
                JSONArray jsonArray = new JSONArray(res);
                for (int i = 0; i<jsonArray.length(); i++){
                    JSONObject jsonObject = jsonArray.getJSONObject(i);
                    resultat += " - " + jsonObject.getString("identifiant") + " - (" + jsonObject.getString("nomSal") + ")\n";
                }
                return resultat;
            }
        } catch (Exception e) {
            Toast.makeText(activityApp ,"erreur : " + e.getLocalizedMessage(), Toast.LENGTH_SHORT);
        }
        return res;
    }
}
