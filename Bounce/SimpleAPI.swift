//
//  SimpleAPI.swift
//  Bounce
//
//  Created by Lorenzo Hernandez on 11/5/17.
//  Copyright © 2017 Dante  Lacey-Thompson. All rights reserved.
//

import Foundation

class SimpleAPI: NSObject{
    
    //Mark: address(es) to load/send
    var address_es = [String]()
    let session = URLSession.shared
    
    override init(){}
    
    func getNewAddress(address: String){
        if(!address_es.contains(address)){
            self.address_es.append(address)
        }
        
        guard let url = URL(string: address) else{
            print("Error: Bad URL")
            return
        }
        
        let urlRequest = URLRequest(url: url)
        
        let task = session.dataTask(with: urlRequest, completionHandler:{
            (data: Data?, response: URLResponse?, error: Error?) in
            if let response = response{
                print(response)
            }
            if let error = error{
                print(error)
            }
        })
        
        task.resume()
    }
    
    
}
