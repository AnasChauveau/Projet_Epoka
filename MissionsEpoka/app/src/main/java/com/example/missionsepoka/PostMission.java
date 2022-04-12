package com.example.missionsepoka;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class PostMission extends AsyncTask<Void, Integer, String> {

    public String urlServiceWeb;
    public Activity activityApp;
    public String postData;

    @Override
    protected String doInBackground(Void... voids) {
        return getServerDataJSON (urlServiceWeb);
    }

    @Override
    protected void onPostExecute (String result){
        EcranConnexion.tvErreur.setText(result);
    }


    private String getServerDataJSON(String urlService) {
        String res ="";
        InputStream inputStream = null;

        URL url;
        try {

            url = new URL(urlService);
            HttpURLConnection connexion = (HttpURLConnection)url.openConnection();
            connexion.setRequestMethod("POST");
            connexion.setDoOutput(true);
            connexion.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");
            connexion.setRequestProperty("Content-Length", Integer.toString(postData.length()));
            connexion.setUseCaches(false);

            try (DataOutputStream dos = new DataOutputStream(connexion.getOutputStream())) {
                dos.writeBytes(postData);
            }

            try (BufferedReader br = new BufferedReader(new InputStreamReader(
                    connexion.getInputStream())))
            {
                String line;
                while ((line = br.readLine()) != null) {
                    System.out.println(line);
                }
            }

            Intent intent = new Intent(activityApp.getApplicationContext(),EcranAccueil.class);
            intent.setFlags((Intent.FLAG_ACTIVITY_CLEAR_TASK+Intent.FLAG_ACTIVITY_NEW_TASK));
            activityApp.startActivity(intent);
            activityApp.overridePendingTransition(android.R.anim.fade_in,android.R.anim.fade_out );

            return res;

        } catch (Exception e) {
            e.printStackTrace();
        }

        return res;
    }
}

