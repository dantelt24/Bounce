package com.example.dantelacey_thompson.javascriptmapcheck;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationManager;
import android.media.MediaPlayer;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;
import android.webkit.PermissionRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;

import android.content.Context;
import android.telephony.TelephonyManager;
import android.view.View;
import android.webkit.WebViewClient;
import android.widget.Toast;


import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;

import java.util.ArrayList;

public class MainActivity extends AppCompatActivity implements GoogleApiClient.ConnectionCallbacks, GoogleApiClient.OnConnectionFailedListener, LocationListener{

//    public Location mLastLocation;

    private WebView mWebView;
    private WebView bWebView;
    private String aID;
    private String IDinfo;
    public static final int MY_PERMISSIONS_REQUEST_LOCATION = 98;
    public static final int MY_PERMISSIONS_REQUEST_PHONE_STATE = 99;

    private GoogleApiClient mGoogleApiClient;
    private LocationRequest mLocationRequest;
    private Location mLastLocation;
    private boolean mRequestingLocationUpdates = false;
    private static int UPDATE_INTERVAL = 1000 * 15;
    private static final int PLAY_SERVICES_RESOLUTION_REQUEST = 9000;


    private class LocationData{
        private String lati;
        private String longi;


        public void setLati(String lati) {
            this.lati = lati;
        }

        public void setLongi(String longi) {
            this.longi = longi;
        }

        public String getLati() {
            return lati;
        }

        public String getLongi() {
            return longi;
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        //Toolbar toolbar = findViewById(R.id.toolbar);
        //setSupportActionBar(toolbar);
        boolean loadingFinished = true;
        boolean redirect = false;
        getRidOfActionBar();
        mWebView = (WebView) findViewById(R.id.activity_main_webview);
        WebSettings webSettings = mWebView.getSettings();
        webSettings.setJavaScriptEnabled(true);
        mWebView.setWebViewClient(new WebViewClient());
        bWebView = (WebView) findViewById(R.id.background_webview);
        WebSettings bgWebSettings = bWebView.getSettings();
        bgWebSettings.setJavaScriptEnabled(true);
        String aID = getDeviceID();
        bWebView.loadUrl("https://bounceapp.online/backend/submitId.php?id=" + aID);
        if(checkPlayServices()){
            buildGoogleApiClient();
            createLocationRequest();
        }
        mWebView.loadUrl("https://bounceapp.online/loaders/appLoader.php");
//        mWebView.loadUrl("https://bounceapp.online/gmaps.php");
//        if(checkStatePermissions()){
//            Log.d("Incheckstatepermissions", "onCreate: In state permissions");
//            if(ContextCompat.checkSelfPermission(this, Manifest.permission.READ_PHONE_STATE) == PackageManager.PERMISSION_GRANTED){
//                IDinfo = getDeviceID();
//                Log.d("StatePMGranted", "IDInfo is" + IDinfo);
//            }
//        }
//        mWebView.loadUrl("https://google.com");
//        String urlToString = "https://bounceapp.online/backend/userTracking.php?lat=123&lon=123&dev=555";
//        mWebView.loadUrl(urlToString);
//        aID = getDeviceID();
//        Log.d("DeviceinfoFromoncreate", "onCreate: " + aID);
//        mWebView.loadUrl("https://bounceapp.online/loaders/mapLoader.php");
        //mWebView.loadUrl("https://bounceapp.online/loaders/appLoader.php");
//        mWebView.loadUrl("https://bounceapp.online/backend/submitId.php?id=" + aID);
//        mWebView.loadUrl("https://bounceapp.online/backend/userTracking.php?lat=36&lon=12");
//      https://bounceapp.online/backend/userTracking.php?lat=36&lon=12

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    private boolean isNetworkConnected() {
        ConnectivityManager connMgr = (ConnectivityManager)
                getSystemService(Context.CONNECTIVITY_SERVICE); // 1
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo(); // 2
        return networkInfo != null && networkInfo.isConnected(); // 3
    }



    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    public String getDeviceID() {
        final TelephonyManager tm = (TelephonyManager) getBaseContext().getSystemService(Context.TELEPHONY_SERVICE);
        String androidId = android.provider.Settings.Secure.getString(getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);
        Log.d("AID Test", "getDeviceID: " + androidId);
        return androidId;
    }

    private boolean checkPlayServices() {
        GoogleApiAvailability apiAvailability = GoogleApiAvailability.getInstance();
        int resultCode = apiAvailability.isGooglePlayServicesAvailable(this);
        if (resultCode != ConnectionResult.SUCCESS) {
            if (apiAvailability.isUserResolvableError(resultCode)) {
                apiAvailability.getErrorDialog(this, resultCode, PLAY_SERVICES_RESOLUTION_REQUEST)
                        .show();
            } else {
                Log.i("GplayError", "This device is not supported.");
                finish();
            }
            return false;
        }
        return true;
    }

    @Override
    protected void onStart() {
        super.onStart();
        if (mGoogleApiClient != null) {
            mGoogleApiClient.connect();
        }
    }

    @Override
    protected void onResume() {
        super.onResume();

        checkPlayServices();
        if (mGoogleApiClient.isConnected()){
            startLocationUpdates();
        }
    }

    protected synchronized void buildGoogleApiClient() {
        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this)
                .addApi(LocationServices.API).build();
    }

    @Override
    public void onConnectionFailed(ConnectionResult result) {
        Log.i("ErrorCode:", "Connection failed: ConnectionResult.getErrorCode() = "
                + result.getErrorCode());
    }

    @Override
    public void onConnected(Bundle arg0) {

        // Once connected with google api, get the location
        displayLocation();
        startLocationUpdates();
    }

    protected void stopLocationUpdates() {
        LocationServices.FusedLocationApi.removeLocationUpdates(
                mGoogleApiClient, this);
    }
    @Override
    public void onConnectionSuspended(int arg0) {
        mGoogleApiClient.connect();
    }

    @Override
    public void onLocationChanged(Location location) {
        // Assign the new location
        mLastLocation = location;

        Toast.makeText(getApplicationContext(), "Location changed!",
                Toast.LENGTH_SHORT).show();

        // Displaying the new location on UI
        displayLocation();
    }

    protected void createLocationRequest(){
        mLocationRequest  = new LocationRequest();
        mLocationRequest.setInterval(UPDATE_INTERVAL);
        mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
    }

    protected void startLocationUpdates(){
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {
            // Check Permissions Now
            final int REQUEST_LOCATION = 2;

            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.ACCESS_FINE_LOCATION)) {
                // Display UI and wait for user interaction
            } else {
                ActivityCompat.requestPermissions(
                        this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                        REQUEST_LOCATION);
            }
        } else {
            // permission has been granted, continue as usual
            LocationServices.FusedLocationApi.requestLocationUpdates(
                    mGoogleApiClient, mLocationRequest, this);
        }
    }

    private void displayLocation() {

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {
            // Check Permissions Now
            final int REQUEST_LOCATION = 2;

            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.ACCESS_FINE_LOCATION)) {
                // Display UI and wait for user interaction
            } else {
                ActivityCompat.requestPermissions(
                        this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION},
                        REQUEST_LOCATION);
            }
        } else {
            // permission has been granted, continue as usual
            Location mLastLocation = LocationServices.FusedLocationApi
                    .getLastLocation(mGoogleApiClient);
            if (mLastLocation != null) {
                double latitude = mLastLocation.getLatitude();
                double longitude = mLastLocation.getLongitude();
                Log.d("Lat and Long", "Lat: " + latitude + " long: " + longitude);
//            lblLocation.setText(latitude + ", " + longitude);
//            mWebView.loadUrl("https://bounceapp.online/backend/userTracking.php?lat=" + latitude + "&lon=" + longitude);
                String aID = getDeviceID();
//                String urlToString = "https://bounceapp.online/backend/userTracking.php?lat=123&lon=123&devID=555";
                String urlToString = "https://bounceapp.online/backend/userTracking.php?lat=" + latitude + "&lon=" + longitude + "&dev=" + aID;
                Log.d("NEwLoCURLID", "displayLocation: Passing Device ID in Location passing" + urlToString);
//                mWebView.loadUrl(urlToString);
                bWebView.loadUrl(urlToString);
                //bWebView.loadUrl("https://bounceapp.online/backend/userTracking.php?lat=" + latitude + "&lon=" + longitude);
            } else {
                Log.d("ErrorCoords", "Error recieving coordinates");
//            lblLocation
//                    .setText("(Couldn't get the location. Make sure location is enabled on the device)");
            }
        }
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        // Check if the key event was the Back button and if there's history
        if ((keyCode == KeyEvent.KEYCODE_BACK) && mWebView.canGoBack()) {
            mWebView.goBack();
            return true;
        }
        // If it wasn't the Back key or there's no web page history, bubble up to the default
        // system behavior (probably exit the activity)
        return super.onKeyDown(keyCode, event);
    }

    public void getRidOfActionBar(){
        try {
            getSupportActionBar().hide();
        }catch(NullPointerException e){
            Log.d("Action Removal error", "There's no action bar.  Plz stahp");
        }
    }
}
