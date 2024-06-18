"use client";

import React, { createContext, useContext } from "react";

// TYPES //


// Define the shape of the |PascalCase|
type |PascalCase-nos|ContextType = {
  // Define the properties and methods of the 
  // Example:
  // someProperty: string;
  // someMethod: (param: string) => void;
};

// Create the Context
const |PascalCase|Context = createContext<|PascalCase-nos|ContextType | null>(null);

/** Custom hook to use the |PascalCase|Context */
export const use|PascalCase|Context = () => {
  const  context = useContext(|PascalCase|Context);
  if ( context === null) {
    throw new Error("use|PascalCase|Context must be used within a |PascalCase|Provider");
  }
  return context;
};

type |PascalCase|ProviderProps = {
  children: React.ReactNode;
};

/** |PascalCase|Provider Component */
export const |PascalCase|Provider: React.FC<|PascalCase|ProviderProps> = ({ children }) => {
  // Define initial  value
  const value: |PascalCase-nos|ContextType = {
    // Initialize your  properties and methods here
    // Example:
    // someProperty: "",
    // someMethod: (param: string) => {},
  };

  return <|PascalCase|Context.Provider value={value}>{children}</|PascalCase|Context.Provider>;
};

/** Custom hook to use the |PascalCase| */
export const useSome = () => {
  const context = useContext(|PascalCase|Context);
  if ( context === null) {
    throw new Error("useSome must be used within a |PascalCase|Provider");
  }
  return context;
};