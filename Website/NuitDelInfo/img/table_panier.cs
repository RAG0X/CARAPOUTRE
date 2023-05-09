using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Site_marchant
{
    #region Table_panier
    public class Table_panier
    {
        #region Member Variables
        protected int _ID;
        protected int _ID_user;
        protected int _ID_voiture;
        #endregion
        #region Constructors
        public Table_panier() { }
        public Table_panier(int ID, int ID_user, int ID_voiture)
        {
            this._ID=ID;
            this._ID_user=ID_user;
            this._ID_voiture=ID_voiture;
        }
        #endregion
        #region Public Properties
        public virtual int ID
        {
            get {return _ID;}
            set {_ID=value;}
        }
        public virtual int ID_user
        {
            get {return _ID_user;}
            set {_ID_user=value;}
        }
        public virtual int ID_voiture
        {
            get {return _ID_voiture;}
            set {_ID_voiture=value;}
        }
        #endregion
    }
    #endregion
}