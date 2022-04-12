package com.example.missionsepoka;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;

public class GetCommune extends AsyncTask<Void, Integer, String> {

    public String urlServiceWeb;
    public Activity activityApp;
    public static ArrayList<String> Commune;

    @Override
    protected String doInBackground(Void... voids) {
        return getServerDataJSON (urlServiceWeb);
    }

    @Override
    protected void onPostExecute (String resultat){
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
            Commune = new ArrayList<>();

            while ((ligne = bufferedReader.readLine()) != null) {
                res += ligne + "\n"; //
                // données délimités par "\n" dans php, ici "\n" permet le saut à la ligne

                //débodage JSON
                JSONArray jsonArray = new JSONArray(res);
                for (int i = 0; i<jsonArray.length(); i++){
                    JSONObject jsonObject = jsonArray.getJSONObject(i);
                    Commune.add(jsonObject.getString("Commune"));

                }

                Intent intent = new Intent(activityApp.getApplicationContext(),EcranMission.class);
                intent.setFlags((Intent.FLAG_ACTIVITY_CLEAR_TASK+Intent.FLAG_ACTIVITY_NEW_TASK));
                activityApp.startActivity(intent);
            }
        } catch (Exception e) {
            Toast.makeText(activityApp ,"erreur : " + e.getLocalizedMessage(), Toast.LENGTH_SHORT);
        }
        return res;
    }
}

