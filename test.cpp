#include "fichier.h"
#include "class.h"

/*float calcule ( float i , float j , float z=6) {
float k = i +j + z;
return k;
}



int main() {
  std::cout<<"hello world !!" << std::endl;
/*int nb_iterations = 100 ;*/
/*
for (int i = 0 ; i <= nb_iterations; i++) {

if (i %5== 0) {
std::cout << "%5 = " << i << "\n";
} else if (i % 2 == 0) {
std::cout << "% 2 = " << i << "\n";

} else {
std::cout << "//// = " << i << "\n";
}}
*/
/*int i = 0;*/
/*do {
std::cout << "i = " << i << "\n";
i++;
} while(i<=10)*/

/*while (i <= 10){
int j=++i;
std::cout << "i = " << j << "\n";
}*/
/*float res=calcule (1 ,3 );
std::cout<<"resultat = " <<res<< std::endl;

return 0;
}*/
/* void MyClass::print() const {
   std::cout << "MyClass instance contains value : " << m_i << std::endl;
}

struct Parent{

int v ;
void print_parent(){std::cout << "MyClass : " << v << std::endl;}
};
struct Son : public Parent {
// ****** Son inherits the members with the following visibility ********



void print(){
std::cout << "MyClass son value : " ;
print_parent();}
// ******************************************************
};
int main(){
Parent p{42};
p.print_parent(); // output : "Parent ; v = 42"
std::cout << "parent value " << p.v << std::endl;
  Son s{};
  s.print();

}*/

/*

int main () {
float * int_ptr = new float{0}; // new returns an int address
*(int_ptr) = 5; // use * operator to get the pointer value
std::cout << "int_ptr = " << int_ptr<< std::endl; // pointer address (hexadecimal)
std::cout << "int value = "<< *int_ptr<< std::endl; // pointed int value
delete int_ptr;
return 0 ;
};*/

/*
int main () {
float i = 3.14;
float* float_ptr = &i; // int_ptr points on i
float& float_ref = i; // int_ref references i
*float_ptr += 2; // i = 3
float_ref += 2; // i = 5
 std::cout << "       r = " << i << std::endl; 
  std::cout << " float_ptr = " << float_ptr << std::endl; // pofloater address (hexadecimal)
  std::cout << "*float_ptr = "<< *float_ptr << std::endl; //    pofloated variable value
  std::cout << " float_ref = " << float_ref << std::endl; // referenced variable value 

  return 0;

}
*/

/*
void function(int i) {
  i++;
}
int main() {
  int i = 3;
  function(i);
  std::cout<< "i = " << i << std::endl; // i = 4 
}*/
/*
struct A{
  int m_i = 0;
  A() {std::cout << "A()" << std::endl;};
  A(int const i) : m_i (i) {
    std::cout << "A(int)" << std::endl;}
  ~A() {std::cout << "~A()" << std::endl;}
  A(A const& a) {
    m_i = a.m_i;
    std::cout << "A(A const& a)" << std::endl;
  } 
  A& operator= (A const& a) {
    m_i = a.m_i;
    std::cout << "A& operator= (A const& a)" << std::endl;
    return *this;
  }
   
}; 

int main(){
  A a(1); // A(int)
  A a2(a); // A (A const& a)
  A a3; // A()
  a3 = a3; // A& operator= (A const& a)
} //~A
*/
struct A{
static int i;
};
int A::i = 1;
int main(){
std::cout << A::i << std::endl; // no need to have an object to access i
A a;
A a2;
std::cout << a.i << std::endl; // = 1
std::cout << a2.i << std::endl; // = 1
// i is the same in all object of class
a.i += 2;
std::cout << a2.i << std::endl;// = 3 !
}




