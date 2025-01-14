public class RefactoringExample {

    public static void main(String[] args) {
        int valor1 = 5;
        int num2 = 10;

        // Operació de suma
        CalcularResultat(valor1, num2);
    }

    private static void CalcularResultat(int valor1, int num2) {
        int result = valor1 + num2;

        System.out.println("El resultat és: " + result);
    }
}
