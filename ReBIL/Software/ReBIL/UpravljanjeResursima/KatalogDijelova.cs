//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace UpravljanjeResursima
{
    using System;
    using System.Collections.Generic;
    
    public partial class KatalogDijelova
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public KatalogDijelova()
        {
            this.Dijelovis = new HashSet<Dijelovi>();
        }
    
        public int SerijskiBrojDIjela { get; set; }
        public string NazivDijela { get; set; }
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<Dijelovi> Dijelovis { get; set; }
    }
}
