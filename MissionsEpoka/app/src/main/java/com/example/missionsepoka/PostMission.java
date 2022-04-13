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
import java.io.OutputStreamWriter;
import java.io.PrintStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;

public class PostMission extends AsyncTask<Void, Integer, String> {

    public String urlServiceWeb;
    public Activity activityApp;
    public String identifiant;
    public String dateDebut;
    public String dateFin;
    public String idCommune;

    @Override
    protected String doInBackground(Void... voids) {
        return getServerDataJSON (urlServiceWeb);
    }

    @Override
    protected void onPostExecute (String result){
        EcranMission.tvTestErreur.setText(result);
    }


    private String getServerDataJSON(String urlService) {
        String res ="";
        InputStream inputStream = null;

        URL url;
        try {

            url = new URL(urlService);
            URLConnection con = url.openConnection();
            con.setDoOutput(true);
            PrintStream ps = new PrintStream(con.getOutputStream());
            ps.print("identifiant="+identifiant);
            ps.print("&dateDebut="+dateDebut);
            ps.print("&dateFin="+dateFin);
            ps.print("&idCommune="+idCommune);
            con.connect();
            inputStream = con.getInputStream();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
            res = bufferedReader.readLine();
            String resultat = "";
            if(res == null){
                ps.close();
                resultat = "La mission a bien été enregistré";
            }else {
                //débodage JSON
                JSONArray jsonArray = new JSONArray(res);
                JSONObject jsonObject = jsonArray.getJSONObject(0);
                resultat = jsonObject.getString("erreur");
            }

            return resultat;

        } catch (Exception e) {
            Toast.makeText(activityApp ,"Erreur lors de l'insertion de la mission !", Toast.LENGTH_SHORT);
        }

        return res;
    }
}

