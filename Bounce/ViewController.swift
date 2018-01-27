//
//  ViewController.swift
//  Bounce
//
//  Created by Dante  Lacey-Thompson on 11/5/17.
//  Copyright © 2017 Dante  Lacey-Thompson. All rights reserved.
//

import UIKit
import CoreLocation

class ViewController: UIViewController, CLLocationManagerDelegate {

    //Mark: variables
    var wait = false
    var locationManager = CLLocationManager()
    let UUIDValue = UIDevice.current.identifierForVendor?.uuidString
    
    //Mark: references to components
    @IBOutlet var bgWebView: UIWebView!
    @IBOutlet var mWebView: UIWebView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        bgWebView.delegate = self
        mWebView.delegate = self
        
        if let uniqID = UUIDValue{
            let uID = "https://bounceapp.online/backend/submitId.php?id=\(uniqID)"
            print(uID)
            self.bgWebView.loadRequest(URLRequest(url: URL(string: uID)!))
                    
        }
        
        // Do any additional setup after loading the view, typically from a nib.
        mWebView.loadRequest(URLRequest(url: URL(string: "https://bounceapp.online/loaders/appLoader.php")!));
        getLocation()
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


    func getLocation(){
        let status  = CLLocationManager.authorizationStatus()
        
        // 2
        if status == .notDetermined {
            locationManager.requestWhenInUseAuthorization()
            return
        }
        
        // 3
        if status == .denied || status == .restricted {
            let alert = UIAlertController(title: "Location Services Disabled", message: "Please enable Location Services in Settings", preferredStyle: .alert)
            
            let okAction = UIAlertAction(title: "OK", style: .default, handler: nil)
            alert.addAction(okAction)
            
            present(alert, animated: true, completion: nil)
            return
        }
        locationManager.delegate = self;
        locationManager.distanceFilter = 1
        locationManager.startUpdatingLocation()
    }
    
    // 1
    func locationManager(_ manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        let currentLocation = locations.last!
        print("Current location: \(currentLocation)")
        if let uniqID = UUIDValue{
            let pass_me = String("https://bounceapp.online/backend/userTracking.php?lat=\(currentLocation.coordinate.latitude)&lon=\(currentLocation.coordinate.longitude)&dev=\(uniqID)")
            print("UniqueIDentifier: \(uniqID)")
            print("URL:\(String(describing: pass_me))")
            self.bgWebView.loadRequest(URLRequest(url: URL(string: pass_me!)!))
        }
    }
    
    
    // 2
    func locationManager(_ manager: CLLocationManager, didFailWithError error: Error) {
        print("Error \(error)")
    }
    
    func locationManager(_ manager: CLLocationManager, didChangeAuthorization status: CLAuthorizationStatus) {
        print("Authorization status change")
        if let currentLocation = manager.location {
            if let pass_me = UUIDValue{
                let url = String("https://bounceapp.online/backend/userTracking.php?lat=\(currentLocation.coordinate.latitude)&lon=\(currentLocation.coordinate.longitude)&dev=\(pass_me)")
                print("UniqueIDentifier: \(pass_me)")
                print("CurrentLocationFromAuthChange: \(currentLocation)")
                print("URL:\(String(describing: url))")
                self.bgWebView.loadRequest(URLRequest(url: URL(string: url!)!))
            }
        }
    }
    
    //Mark: Actions
    
    @IBAction func goBack(_ sender: Any) {
        if(mWebView.canGoBack){
            mWebView.goBack()
            return
        }
        var navigationArray = navigationController?.viewControllers ?? [Any]()
        // [navigationArray removeAllObjects];    // This is just for remove all view controller from navigation stack.
        print(navigationArray.count)
        navigationArray.remove(at: 0)
        // You can pass your index here
        navigationController?.viewControllers = (navigationArray as? [UIViewController])!
        performSegue(withIdentifier: "webViewToTitle", sender: self)
    }
}
extension ViewController:UIWebViewDelegate{
    func webView(_ webView: UIWebView, didFailLoadWithError error: Error) {
        print(error.localizedDescription)
        print("failed")
    }
    func webView(_ webView: UIWebView, shouldStartLoadWith request: URLRequest, navigationType: UIWebViewNavigationType) -> Bool {
        self.wait = true
        print("we should be working")
        return true
    }
    func webViewDidStartLoad(_ webView: UIWebView) {
        print("we're starting!")
    }
    func webViewDidFinishLoad(_ webView: UIWebView) {
        self.wait = false
        print("FEENISH!")
    }
}

