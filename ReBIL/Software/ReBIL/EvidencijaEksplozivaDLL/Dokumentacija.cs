//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace EvidencijaEksplozivaDLL
{
    using System;
    using System.Collections.Generic;
    
    public partial class Dokumentacija
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public Dokumentacija()
        {
            this.Projekts = new HashSet<Projekt>();
        }
    
        public int IDDOkumentacija { get; set; }
        public string Naziv { get; set; }
        public byte[] Rok { get; set; }
        public string Status { get; set; }
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<Projekt> Projekts { get; set; }
    }
}
