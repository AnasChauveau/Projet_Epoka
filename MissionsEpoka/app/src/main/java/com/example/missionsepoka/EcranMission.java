package com.example.missionsepoka;


import android.app.Activity;
import android.app.DatePickerDialog;
import android.app.Dialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

import java.util.Calendar;

public class EcranMission extends Activity {
    public static TextView tvTestErreur;

    EditText dateDebut;
    EditText dateFin;
    DatePickerDialog.OnDateSetListener setListener;
    TextView textView;
    Dialog dialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_ajout_mission);

        dateDebut = (EditText) findViewById(R.id.etDateDebut);
        dateFin = (EditText) findViewById(R.id.etDateFin);

        textView = findViewById(R.id.tvRecherche);
        tvTestErreur = (TextView)  findViewById(R.id.tvTestErreur);

        Calendar calendar = Calendar.getInstance();
        final int year = calendar.get(Calendar.YEAR);
        final int month = calendar.get(Calendar.MONTH);
        final int day = calendar.get(Calendar.DAY_OF_MONTH);

        dateDebut.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                DatePickerDialog datePickerDialog = new DatePickerDialog(
                        EcranMission.this, android.R.style.Theme_Holo_Light_Dialog_MinWidth,
                        setListener,year,month,day);
                datePickerDialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
                datePickerDialog.show();
            }
        });

        setListener = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                month = month + 1;
                String date = day+"/"+month+"/"+year;
                dateDebut.setText(date);
            }
        };

        dateDebut.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                DatePickerDialog datePickerDialog = new DatePickerDialog(
                        EcranMission.this, new DatePickerDialog.OnDateSetListener() {
                            @Override
                            public void onDateSet (DatePicker view, int year, int month, int day) {
                                month = month +1;
                                String date = day+"/"+month+"/"+year;
                                dateDebut.setText(date);
                            }
                },year, month, day);
                datePickerDialog.show();
            }
        });



        textView.setOnClickListener(new View.OnClickListener(){
            @Override
            public  void onClick(View b){

                dialog = new Dialog(EcranMission.this);
                dialog.setContentView(R.layout.dialog_searchable_spinner);
                dialog.getWindow().setLayout(650, 800);
                dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
                dialog.show();

                EditText etRecherche = dialog.findViewById(R.id.etRecherche);
                ListView listeCommune = dialog.findViewById(R.id.listeCommune);

                ArrayAdapter<String> adapter = new ArrayAdapter<>(EcranMission.this,
                        android.R.layout.simple_list_item_1,GetCommune.Commune);
                listeCommune.setAdapter(adapter);
                etRecherche.addTextChangedListener(new TextWatcher() {
                    @Override
                    public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                    }

                    @Override
                    public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                        adapter.getFilter().filter((charSequence));
                    }

                    @Override
                    public void afterTextChanged(Editable editable) {

                    }
                });

                listeCommune.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                        textView.setText(adapter.getItem(i));
                        dialog.dismiss();
                    }
                });
            }
        });
    }

    public void Envoyer(View v){
        TextView commune;


        commune = (TextView) findViewById(R.id.tvRecherche);
        String idCommune = commune.getText().toString();
        String[] tableCommune = idCommune.split("-");



        PostMission tacheAsynchrone = new PostMission();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Ajout_mission.php";
        tacheAsynchrone.identifiant = GetSalarie.pseudo;
        tacheAsynchrone.dateDebut = dateDebut.getText().toString();
        tacheAsynchrone.dateFin = dateFin.getText().toString();
        tacheAsynchrone.idCommune = tableCommune[1];
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();
    }
}