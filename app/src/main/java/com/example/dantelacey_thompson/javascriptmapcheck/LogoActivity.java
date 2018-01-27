package com.example.dantelacey_thompson.javascriptmapcheck;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.media.MediaPlayer;
import android.net.Uri;
import android.os.Build;
import android.support.constraint.ConstraintLayout;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.VideoView;

import java.io.File;

public class LogoActivity extends AppCompatActivity implements MediaPlayer.OnCompletionListener{

    private static final String ACT_NAME = "LOGO";
    private static final int ALL_PERMISSIONS = 1;
    private VideoView mLogo;
    private boolean newUser = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_logo);

        //Check New User
        ////////insert make call to new user check code here
//        newUser = checkNewUser();

        String[] PERMISSIONS = {Manifest.permission.INTERNET, Manifest.permission.READ_PHONE_STATE, Manifest.permission.ACCESS_FINE_LOCATION};

        if(!hasPermissions(this, PERMISSIONS)){
            ActivityCompat.requestPermissions(this, PERMISSIONS, ALL_PERMISSIONS);
        }

        begoneBars();

        mLogo = (VideoView)findViewById(R.id.logoView);

        //stretch fullscreen
        DisplayMetrics metrics = new DisplayMetrics();
        getWindowManager().getDefaultDisplay().getMetrics(metrics);
        ConstraintLayout.LayoutParams params = (ConstraintLayout.LayoutParams)mLogo.getLayoutParams();
        params.width = metrics.widthPixels;
        params.height = metrics.heightPixels;
        params.leftMargin = 0;
        mLogo.setLayoutParams(params);

        //add listener, logo, play it!
        mLogo.setOnCompletionListener(this);
        Uri uri = Uri.parse("android.resource://com.example.dantelacey_thompson.javascriptmapcheck/raw/logo");
        mLogo.setVideoURI(uri);
        mLogo.requestFocus();
        mLogo.start();
    }

    @Override
    public void onResume(){
        super.onResume();
        begoneBars();
        mLogo.requestFocus();
        mLogo.start();
    }

    @Override
    public void onCompletion(MediaPlayer mp) {
        Intent i;
        i = new Intent(this, MainActivity.class);
        startActivity(i);
    }

//    private boolean checkNewUser(){
//        //make call/get info
//        return true;
//    }

    private void begoneBars(){
        //Don't need to see the action bar or the status bar
        try {
            getSupportActionBar().hide();
        }catch(NullPointerException e){
            Log.d(ACT_NAME, "There's no action bar.  Plz stahp");
        }

        //no status bar
        if(Build.VERSION.SDK_INT < 16){
            getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                    WindowManager.LayoutParams.FLAG_FULLSCREEN);
        }else{
            View decorView = getWindow().getDecorView();
            int ui = View.SYSTEM_UI_FLAG_FULLSCREEN;
            decorView.setSystemUiVisibility(ui);
        }
    }

    public static boolean hasPermissions(Context context, String... permissions) {
        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.M && context != null && permissions != null) {
            for (String permission : permissions) {
                if (ActivityCompat.checkSelfPermission(context, permission) != PackageManager.PERMISSION_GRANTED) {
                    return false;
                }
            }
        }
        return true;
    }
}

//    String[] PERMISSIONS = {Manifest.permission.INTERNET, Manifest.permission.READ_PHONE_STATE, Manifest.permission.ACCESS_FINE_LOCATION};
//
//        if(!hasPermissions(this, PERMISSIONS)){
//                ActivityCompat.requestPermissions(this, PERMISSIONS, ALL_PERMISSIONS);
//                }
//public static boolean hasPermissions(Context context, String... permissions) {
//    if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.M && context != null && permissions != null) {
//        for (String permission : permissions) {
//            if (ActivityCompat.checkSelfPermission(context, permission) != PackageManager.PERMISSION_GRANTED) {
//                return false;
//            }
//        }
//    }
//    return true;
//}